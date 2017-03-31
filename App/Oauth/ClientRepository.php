<?php 
/**
 * @Author: lerko
 * @Date:   2017-03-29 15:30:55
 * @Last Modified by:   lerko
 * @Last Modified time: 2017-03-29 16:05:56
 */
namespace App\Oauth;

use League\OAuth2\Server\Repositories as Repositories;
use League\OAuth2\Server\Entities\Traits as Traits;

class ClientRepository implements Repositories\ClientRepositoryInterface
{
	/**
	 *  {@inheritdoc}
	 */
	public function getClientEntity($clientIdentifier, $grantType, $clientSecret = null, $mustValidateSecret = true){

	}
}