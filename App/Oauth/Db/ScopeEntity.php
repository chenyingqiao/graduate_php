<?php 
/**
 * @Author: lerko
 * @Date:   2017-04-06 19:48:19
 * @Last Modified by:   lerko
 * @Last Modified time: 2017-04-06 19:52:14
 */
namespace App\Oauth\Db;

use App\Oauth\Db\Traits\EntityTrait;
use Phero\Database\DbUnit;

/**
* 
*/
class ScopeEntity extends DbUnit implements League\OAuth2\Server\Entities\ScopeEntityInterface
{
	use EntityTrait;

	public $id;

	public function jsonSerialize()
    {
        return $this->getIdentifier();
    }

}