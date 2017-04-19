<?php 

namespace App\Model\DataAccess;

use App\Model\BlogEntity;
/**
 * @Author: ‘chenyingqiao’
 * @Date:   2017-04-16 22:09:21
 * @Last Modified by:   ‘chenyingqiao’
 * @Last Modified time: 2017-04-19 00:31:46
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
		// $HasBlog=$Blog->whereEq("title",$data['title'])->whereEq('id',$data['id'])->find();
		$HasBlog=$Blog->whereEq("title",$data['title'])->find();
		if(empty($HasBlog)){
			$Blog->update_time=time();
			$Blog->create_time=time();
			$Blog->uid=$data['user_id'];
			$Blog->id=null;
			$Blog->markdown=$data['markdown'];
			$effect=$Blog->insert();
		}else{
			$Blog=new BlogEntity($data);
			$Blog->id=$HasBlog['id'];
			$effect=$Blog->whereEq("id",$HasBlog['id'])->update();
		}
		if($effect||$effect===0){
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

	/**
	 * 删除文章
	 * @Author   Lerko
	 * @DateTime 2017-04-18T07:44:55+0800
	 * @param    [type]                   $aid [description]
	 * @return   [type]                        [description]
	 */
	public static function deleteArticle($aid)
	{
		return (new BlogEntity())->whereEq("id",$aid)->delete();
	}

	public function like($aid)
	{
		$Blog=new BlogEntity();
		$Blog->like=$Blog->whereEq("id",$aid)->find("like")+1;
		$effect=$Blog->whereEq("id",$aid)->update();
		if($effect){
			return $Blog->like;
		}
		return false;
	}
}