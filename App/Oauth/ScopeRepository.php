<?php 
/**
 * @Author: lerko
 * @Date:   2017-04-01 16:50:17
 * @Last Modified by:   lerko
 * @Last Modified time: 2017-04-01 17:00:32
 */
namespace App\Oauth;

use League\OAuth2\Server\Repositories as Repositories;
use League\OAuth2\Server\Entities\Traits as Traits;

/**
* 
*/
class ScopeRepostitory extends Repositories\ScopeRepositoryInterface
{
	 /**
     * 获取scope的实体类
     */
    public function getScopeEntityByIdentifier($identifier){

    }

    /**
     * 
     */
    public function finalizeScopes(
        array $scopes,
        $grantType,
        ClientEntityInterface $clientEntity,
        $userIdentifier = null
    ){

    }
}