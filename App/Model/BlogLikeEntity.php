<?php 

namespace App\Model;

use Phero\Database\DbUnit;
/**
 * @Author: ‘chenyingqiao’
 * @Date:   2017-04-15 15:11:04
 * @Last Modified by:   ‘chenyingqiao’
 * @Last Modified time: 2017-04-15 16:01:30
 */
// show create table blog_like;
/**
* @Table[name=blog_like]
*/
class BlogLikeEntity extends DbUnit{
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
	 * @Field[name=article_id]
	 * @var [type]
	 */
	public $article_id;
}