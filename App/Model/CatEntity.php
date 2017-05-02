<?php 

namespace App\Model;

use Phero\Database\DbUnit;
/**
 * @Author: ‘chenyingqiao’
 * @Date:   2017-04-23 21:16:39
 * @Last Modified by:   ‘chenyingqiao’
 * @Last Modified time: 2017-04-23 22:20:31
 */
// show create table cat;

/**
* @Table[name=cat]
*/
class CatEntity extends DbUnit
{
	/**
	 * @Field[name=id,alias=_id]
	 * @var [type]
	 */
	public $id;

	/**
	 * @Field[name=name]
	 * @var [type]
	 */
	public $name;
}