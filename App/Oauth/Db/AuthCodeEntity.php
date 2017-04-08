<?php 
/**
 * @Author: lerko
 * @Date:   2017-04-06 19:32:44
 * @Last Modified by:   ‘chenyingqiao’
 * @Last Modified time: 2017-04-08 15:26:19
 */
namespace App\Oauth\Db;

use App\Oauth\Db\Traits\EntityTrait;
use App\Oauth\Db\Traits\TokenTrait;
use Phero\Database\DbUnit;

/**
* @Table[name=auth]
*/
class AuthCodeEntity extends DbUnit implements League\OAuth2\Server\Entities\AuthCodeEntityInterface
{
	use TokenTrait,EntityTrait;
	/**
	 * @Field[name=id]
	 * @var [type]
	 */
	public $id;
	/**
	 * @Field[name=client_id]
	 * @var [type]
	 */
	public $client_id;
	/**
	 * @Field[name=expiry_time]
	 * @var [type]
	 */
	public $expiry_time;
	/**
	 * @Field[name=user_id]
	 * @var [type]
	 */
	public $user_id;
	/**
	 * @Field[name=scope]
	 * @var [type]
	 */
	public $scope;
	/**
	 * @Field[name=redirect_url]
	 * @var [type]
	 */
	public $redirect_url;

	/**
	 * @Field[name=revoke]
	 * @var [type]
	 */
	public $revoke;

	 /**
     * @return string
     */
    public function getRedirectUri()
    {
        return $this->redirect_url;
    }

    /**
     * @param string $uri
     */
    public function setRedirectUri($uri)
    {
        $this->redirect_url = $uri;
    }


}
