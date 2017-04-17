<?php 
/**
 * @Author: lerko
 * @Date:   2017-04-06 19:48:19
 * @Last Modified by:   ‘chenyingqiao’
 * @Last Modified time: 2017-04-08 15:47:38
 */
namespace App\Oauth\Db;

use App\Oauth\Db\Traits\EntityTrait;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use Phero\Database\DbUnit;

/**
* @Table[name=scope]
*/
class ScopeEntity extends DbUnit implements ScopeEntityInterface
{
	use EntityTrait;

	public $id;

	public $name;

	public function jsonSerialize()
    {
        return $this->getIdentifier();
    }

}