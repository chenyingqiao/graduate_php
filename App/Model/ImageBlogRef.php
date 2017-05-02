<?php 
/**
 * @Author: lerko
 * @Date:   2017-05-02 17:35:36
 * @Last Modified by:   lerko
 * @Last Modified time: 2017-05-02 17:49:04
 */

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
* @Table[name=image_blog_ref]
*/
class ImageBlogRef extends DbUnit
{
	/**
	 * @Field[name=id,alias=_id]
	 * @var [type]
	 */
	public $id;

	/**
	 * @Field[name=blog_id]
	 * @var [type]
	 */
	public $blog_id;

	/**
	 * @Field[name=image_id]
	 * @var [type]
	 */
	public $image_id;

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