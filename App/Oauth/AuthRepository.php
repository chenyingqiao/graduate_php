<?php 
/**
 * @Author: lerko
 * @Date:   2017-04-01 17:06:38
 * @Last Modified by:   lerko
 * @Last Modified time: 2017-04-01 17:13:30
 */
namespace App\Oauth;

use League\OAuth2\Server\Repositories as Repositories;
use League\OAuth2\Server\Entities\Traits as Traits;

/**
* 
*/
class AuthRepository extends Repositories\AuthCodeRepositoryInterface
{
	/**
     * Creates a new AuthCode
     *
     * @return AuthCodeEntityInterface
     */
    public function getNewAuthCode(){}

    /**
     * Persists a new auth code to permanent storage.
     *
     * @param AuthCodeEntityInterface $authCodeEntity
     */
    public function persistNewAuthCode(AuthCodeEntityInterface $authCodeEntity){}

    /**
     * Revoke an auth code.
     *
     * @param string $codeId
     */
    public function revokeAuthCode($codeId){}

    /**
     * Check if the auth code has been revoked.
     *
     * @param string $codeId
     *
     * @return bool Return true if this code has been revoked
     */
    public function isAuthCodeRevoked($codeId){}
}