<?php 

namespace App\Model\DataAccess;

use App\Model\BlogEntity;
/**
 * @Author: ‘chenyingqiao’
 * @Date:   2017-04-16 22:09:21
 * @Last Modified by:   ‘chenyingqiao’
 * @Last Modified time: 2017-04-16 23:25:53
 */

/**
* 
*/
class ArticleDataAccess
{
	/**
	 * 添加文章
	 * @Author   Lerko
	 * @DateTime 2017-04-16T22:15:56+0800
	 * @param    [type]                   $data [description]
	 */
	public static function addArticle($data){
		if(empty($data['title'])||empty($data['content'])){
			return [false,"标题或者内容为空"];
		}
		$Blog=new BlogEntity($data);
		$HasBlog=$Blog->whereEq("title",$data['title'])->find();
		if(empty($HasBlog)&&$data['id']==-1){
			$Blog->update_time=time();
			$Blog->create_time=time();
			$Blog->id=false;
			$effect=$Blog->insert();
		}else{
			$Blog->update_time=time();
			$effect=$Blog->whereEq("id",$data['id'])->update();
		}
		if($effect){
			return [true];
		}
		return [false,"保存或者更新失败".$Blog->error().$Blog->sql()];
	}

	/**
	 * 获取文章id通过标题
	 * @Author   Lerko
	 * @DateTime 2017-04-16T22:16:12+0800
	 * @param    [type]                   $title [description]
	 * @return   [type]                          [description]
	 */
	public static function getIdByTitle($title){
		$id= (new BlogEntity())->whereEq("title",$title)->find("id");
		if(empty($id)){
			return -1;
		}
		return $id;
	}
}