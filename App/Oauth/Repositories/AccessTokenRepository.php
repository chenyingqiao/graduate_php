<?php
/**
 * @author      Alex Bilbie <hello@alexbilbie.com>
 * @copyright   Copyright (c) Alex Bilbie
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/thephpleague/oauth2-server
 */

namespace App\Oauth\Repositories;

use App\Oauth\Db\AccessTokenEntity;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;


class AccessTokenRepository implements AccessTokenRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function persistNewAccessToken(AccessTokenEntityInterface $accessTokenEntity)
    {
        $accessTokenEntity->client_id=$accessTokenEntity->client->id;
        $accessTokenEntity->expiry_time=$accessTokenEntity->ExpiryDateTime->format('Y-m-d H:i:s');
        $accessTokenEntity->scope=array_keys($accessTokenEntity->scopes)[0];
        $effect=$accessTokenEntity->insert();
        if($effect)
            return $accessTokenEntity;
        else
            return null;
    }

    /**
     * {@inheritdoc}
     */
    public function revokeAccessToken($tokenId)
    {
        $accessTokenEntity=new AccessTokenEntity();
        $accessTokenEntity->revoke=0;
        $effect=$accessTokenEntity->whereEq("access_token_id",$tokenId)->update();
        if($effect){
            return $tokenId;
        }
        return 0;
    }

    /**
     * {@inheritdoc}
     */
    public function isAccessTokenRevoked($tokenId)
    {
        $accessTokenEntity=new AccessTokenEntity();
        $result=$accessTokenEntity->whereEq("access_token_id",$tokenId)->find();
        return $result['revoke']==1?false:true;
    }

    /**
     * {@inheritdoc}
     */
    public function getNewToken(ClientEntityInterface $clientEntity, array $scopes, $userIdentifier = null)
    {
        $accessToken = new AccessTokenEntity();
        $accessToken->setClient($clientEntity);
        foreach ($scopes as $scope) {
            $accessToken->addScope($scope);
        }
        $accessToken->setUserIdentifier($userIdentifier);

        return $accessToken;
    }
}
