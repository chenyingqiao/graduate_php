<?php 
/**
 * @Author: lerko
 * @Date:   2017-05-02 17:35:16
 * @Last Modified by:   lerko
 * @Last Modified time: 2017-05-02 17:49:09
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
* @Table[name=image_warehouse]
*/
class ImageWarehouse extends DbUnit
{
	/**
	 * @Field[name=id]
	 * @var [type]
	 */
	public $id;

	/**
	 * @Field[name=image_path]
	 * @var [type]
	 */
	public $image_path;

	/**
	 * @Field[name=image_cut_path]
	 * @var [type]
	 */
	public $image_cut_path;

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