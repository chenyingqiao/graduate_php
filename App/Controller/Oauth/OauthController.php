<?php 
/**
 * @Author: ‘chenyingqiao’
 * @Date:   2017-04-08 13:33:21
 * @Last Modified by:   ‘chenyingqiao’
 * @Last Modified time: 2017-04-08 15:45:41
 */
namespace App\Controller\Oauth;

use App\Oauth\Repositories\AccessTokenRepository;
use App\Oauth\Repositories\ClientRepository;
use App\Oauth\Repositories\RefreshTokenRepository;
use App\Oauth\Repositories\ScopeRepository;
use App\Oauth\Repositories\UserRepository;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Grant\PasswordGrant;
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
		$server=new AuthorizationServer(
				new ClientRepository(),                 // instance of ClientRepositoryInterface
	            new AccessTokenRepository(),            // instance of AccessTokenRepositoryInterface
	            new ScopeRepository(),                  // instance of ScopeRepositoryInterface
	            'file://' . __DIR__ . '/key/private.key',    // path to private key
	            'file://' . __DIR__ . '/key/public.key'      // path to public key
			);
        $grant = new PasswordGrant(
            new UserRepository(),           // instance of UserRepositoryInterface
            new RefreshTokenRepository()    // instance of RefreshTokenRepositoryInterface
        );
        $server->enableGrantType(
            $grant,
            new \DateInterval('PT1H') // access tokens will expire after 1 hour
        );
		return $server;
	}
}