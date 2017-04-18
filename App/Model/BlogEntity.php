<?php 

namespace App\Model;

use Phero\Database\DbUnit;
/**
 * @Author: ‘chenyingqiao’
 * @Date:   2017-04-15 15:11:16
 * @Last Modified by:   ‘chenyingqiao’
 * @Last Modified time: 2017-04-17 22:29:13
 */

//show create table blog;

/**
 * @Table[name=blog]
*/
class BlogEntity extends DbUnit{
	/**
	 * @Field[name=id]
	 * @Primary
	 * @var [type]
	 */
	public $id;
	/**
	 * @Field[name=uid]
	 * @var [type]
	 */
	public $uid;
	/**
	 * @Field[name=markdown]
	 * @var [type]
	 */
	public $markdown;
	/**
	 * @Field[name=title]
	 * @var [type]
	 */
	public $title;
	/**
	 * @Field[name=discreption]
	 * @var [type]
	 */
	public $discreption;
	/**
	 * @Field[name=content]
	 * @var [type]
	 */
	public $content;
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
	 * @Field[name=cat_id]
	 * @var [type]
	 */
	public $cat_id;
}