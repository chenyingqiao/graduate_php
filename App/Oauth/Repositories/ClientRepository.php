<?php
/**
 * @author      Alex Bilbie <hello@alexbilbie.com>
 * @copyright   Copyright (c) Alex Bilbie
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/thephpleague/oauth2-server
 */

namespace App\Oauth\Repositories;

use App\Oauth\Db\ClientEntity;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;

class ClientRepository implements ClientRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getClientEntity($clientIdentifier, $grantType, $clientSecret = null, $mustValidateSecret = true)
    {
        $clientEntity=new ClientEntity();
        $client_result=$clientEntity->whereEq("id",$clientIdentifier)->find();
        if (empty($client_result)) {
            return;
        }
        //检测是否是加密选项
        if (
            $mustValidateSecret == true
            && $client_result['is_confidential'] == 1
            && password_verify($clientSecret, $client_result['secret']) === false
        ) {
            return;
        }
        $client = new ClientEntity();
        $client->setIdentifier($clientIdentifier);
        $client->setName($client_result['name']);
        $client->setRedirectUri($client_result['redirect_url']);
        return $client;
    }
}
