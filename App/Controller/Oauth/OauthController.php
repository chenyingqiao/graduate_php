<?php 
/**
 * @Author: ‘chenyingqiao’
 * @Date:   2017-04-08 13:33:21
 * @Last Modified by:   ‘chenyingqiao’
 * @Last Modified time: 2017-04-09 07:41:11
 */
namespace App\Controller\Oauth;

use App\Oauth\Repositories\AccessTokenRepository;
use App\Oauth\Repositories\AuthCodeRepository;
use App\Oauth\Repositories\ClientRepository;
use App\Oauth\Repositories\RefreshTokenRepository;
use App\Oauth\Repositories\ScopeRepository;
use App\Oauth\Repositories\UserRepository;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Grant\AuthCodeGrant;
use League\OAuth2\Server\Grant\PasswordGrant;
use League\OAuth2\Server\Grant\RefreshTokenGrant;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
* 
*/
class OauthController
{
	public function passwordOauth(ServerRequestInterface $request,ResponseInterface $response,array $args){
		$server=$this->getOauthService();
		try {
            // Try to respond to the access token request
            return $server->respondToAccessTokenRequest($request, $response);
        } catch (OAuthServerException $exception) {

            // All instances of OAuthServerException can be converted to a PSR-7 response
            return $exception->generateHttpResponse($response);
        } catch (\Exception $exception) {
            // Catch unexpected exceptions
            $body = $response->getBody();
            $body->write($exception->getMessage());
            return $response;
        }
	}


	private function getOauthService(){
        $clientRepository = new ClientRepository();
        $accessTokenRepository = new AccessTokenRepository();
        $scopeRepository = new ScopeRepository();
        $authCodeRepository = new AuthCodeRepository();
        $refreshTokenRepository = new RefreshTokenRepository();
        $privateKeyPath = 'file://' . __DIR__ . '/key/private.key';
        $publicKeyPath = 'file://' . __DIR__ . '/key/public.key';

		$server=new AuthorizationServer(
    			$clientRepository,
                $accessTokenRepository,
                $scopeRepository,
                $privateKeyPath,
                $publicKeyPath
			);
        //密码验证服务器
        $grant = new PasswordGrant(
            new UserRepository(),           // instance of UserRepositoryInterface
            new RefreshTokenRepository()    // instance of RefreshTokenRepositoryInterface
        );
        $server->enableGrantType(
            $grant,
            new \DateInterval('PT1H') // access tokens will expire after 1 hour
        );

        $refreshTokenGrant=new RefreshTokenGrant($refreshTokenRepository);
         $grant->setRefreshTokenTTL(new \DateInterval('P1M'));
        $server->enableGrantType(
            $refreshTokenGrant,
            new \DateInterval('PT1H') 
            );

        $server->enableGrantType(
            new AuthCodeGrant(
                $authCodeRepository,
                $refreshTokenRepository,
                new \DateInterval('PT10M')
            ),
            new \DateInterval('PT1H')
        );
        
		return $server;
	}
}