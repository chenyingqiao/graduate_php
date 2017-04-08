<?php
/**
 * @author      Alex Bilbie <hello@alexbilbie.com>
 * @copyright   Copyright (c) Alex Bilbie
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/thephpleague/oauth2-server
 */

namespace App\Oauth\Repositories;

use League\OAuth2\Server\Entities\AuthCodeEntityInterface;
use League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface;
use OAuth2ServerExamples\Entities\AuthCodeEntity;

class AuthCodeRepository implements AuthCodeRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function persistNewAuthCode(AuthCodeEntityInterface $authCodeEntity)
    {
        $effect=$authCodeEntity->insert();
        if($effect)
            return $authCodeEntity;
        else
            return null;
    }

    /**
     * {@inheritdoc}
     */
    public function revokeAuthCode($codeId)
    {
        $authCodeEntity=new AuthCodeEntity();
        $authCodeEntity->revoke=0;
        $effect=$authCodeEntity->whereEq("id",$codeId)->update();
        if($effect){
            return $tokenId;
        }
        return 0;
    }

    /**
     * {@inheritdoc}
     */
    public function isAuthCodeRevoked($codeId)
    {
        $authCodeEntity=new AuthCodeEntity();
        $revoke=$authCodeEntity->whereEq("id",$codeId)->find("revoke");
        return $revoke;
    }

    /**
     * {@inheritdoc}
     */
    public function getNewAuthCode()
    {
        return new AuthCodeEntity();
    }
}
