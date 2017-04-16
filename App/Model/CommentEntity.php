<?php 

namespace App\Model;

use Phero\Database\DbUnit;
/**
 * @Author: ‘chenyingqiao’
 * @Date:   2017-04-15 15:10:49
 * @Last Modified by:   ‘chenyingqiao’
 * @Last Modified time: 2017-04-16 13:40:04
 */
// show create table common;
/**
* @Table[name=comment]
*/
class CommentEntity extends DbUnit{
	/**
	 * @Field[name=id]
	 * @Primary
	 * @var [type]
	 */
	public $id;
	/**
	 * @Field[name=content]
	 * @var [type]
	 */
	public $content;
	/**
	 * @Field[name=uid]
	 * @var [type]
	 */
	public $uid;
	/**
	 * @Field[name=blog_id]
	 * @var [type]
	 */
	public $blog_id;
	/**
	 * @Field[name=ref_comment_id]
	 * @var [type]
	 */
	public $ref_comment_id;
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
}