<?php  
/**
 * @Author: lerko
 * @Date:   2017-04-06 15:40:23
 * @Last Modified by:   ‘chenyingqiao’
 * @Last Modified time: 2017-04-09 09:44:54
 */
namespace App\Oauth\Db;

use App\Oauth\Db\Traits\EntityTrait;
use App\Oauth\Db\Traits\TokenTrait;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\Traits\AccessTokenTrait;
use Phero\Database\DbUnit;

/**
* @Table[name=access_token]
*/
class AccessTokenEntity extends DbUnit implements AccessTokenEntityInterface
{
	use AccessTokenTrait,TokenTrait,EntityTrait;

	/**
	 * @Field[name=access_token_id]
	 * @var [type]
	 */
	public $id;

	/**
	 * @Field[name=id]
	 * @var [type]
	 */
	public $auto_id;

	/**
	 * @Field[name=client_id]
	 * @var [type]
	 */
	public $client_id;

	public $client;

	/**
	 * @Field[name=expiry_time]
	 * @var [type]
	 */
	public $expiry_time;

	public $ExpiryDateTime;

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
	public $scopes;

	/**
	 * @Field[name=revoke,type=int]
	 * @var [type]
	 */
	public $revoke;
}