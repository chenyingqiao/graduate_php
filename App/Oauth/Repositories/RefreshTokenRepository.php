<?php
/**
 * @author      Alex Bilbie <hello@alexbilbie.com>
 * @copyright   Copyright (c) Alex Bilbie
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/thephpleague/oauth2-server
 */

namespace App\Oauth\Repositories;

use App\Oauth\Db\RefreshTokenEntity;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;

class RefreshTokenRepository implements RefreshTokenRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function persistNewRefreshToken(RefreshTokenEntityInterface $refreshTokenEntity)
    {
        // Some logic to persist the refresh token in a database
        $refreshTokenEntity->access_token_id=$refreshTokenEntity->accessToken->id;
        $refreshTokenEntity->expiry_time=$refreshTokenEntity->expiryDateTime->format('Y-m-d H:i:s');
        $effet=$refreshTokenEntity->insert();
        if($effet)
            return $refreshTokenEntity;
        else
            return null;
    }

    /**
     * {@inheritdoc}
     */
    public function revokeRefreshToken($tokenId)
    {
        // Some logic to revoke the refresh token in a database
        $refreshTokenEntity=new RefreshTokenEntity();
        $refreshTokenEntity->revoke=0;
        $effect=$refreshTokenEntity->whereEq("id",$tokenId)->update();
        if($effect){
            return $tokenId;
        }
        return 0;
    }

    /**
     * {@inheritdoc}
     */
    public function isRefreshTokenRevoked($tokenId)
    {
        $refreshTokenEntity=new RefreshTokenEntity();
        $result=$refreshTokenEntity->whereEq("id",$tokenId)->find();
        return $result['revoke'];
    }

    /**
     * {@inheritdoc}
     */
    public function getNewRefreshToken()
    {
        return new RefreshTokenEntity();
    }
}
