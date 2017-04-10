<?php 
/**
 * @Author: ‘chenyingqiao’
 * @Date:   2017-04-08 11:47:50
 * @Last Modified by:   ‘chenyingqiao’
 * @Last Modified time: 2017-04-09 17:37:09
 */
namespace App\Model;

use App\Oauth\Db\Traits\EntityTrait;
use League\OAuth2\Server\Entities\UserEntityInterface;
use Phero\Database\DbUnit;

/**
* @Table[name=user]
*/
class UserEntity extends DbUnit implements UserEntityInterface
{
	use EntityTrait;
	/**
	 * @Field[name=id,type=int]
	 * @var [type]
	 */
	public $id;

	/**
	 * @Field[name=username]
	 * @var [type]
	 */
	public $username;

	/**
	 * @Field[name=password]
	 * @var [type]
	 */
	public $password;

	/**
	 * @Field[name=create_time]
	 * @var [type]
	 */
	public $create_time;

	/**
	 * @Field[name=update_time]
	 * @var [type]
	 */
	public $update_time;

	/**
	 * @Field[name=head_image]
	 * @var [type]
	 */
	public $head_image;

	/**
	 * @Field[name=sex]
	 * @var [type]
	 */
	public $sex;
}