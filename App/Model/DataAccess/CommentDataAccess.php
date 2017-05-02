<?php 

namespace App\Model\DataAccess;

use App\Model\CommentEntity;
use App\Model\DataAccess\UserDataAccess;
use App\Tool\Tool;
/**
 * @Author: ‘chenyingqiao’
 * @Date:   2017-04-16 11:47:05
 * @Last Modified by:   ‘chenyingqiao’
 * @Last Modified time: 2017-04-19 08:43:07
 */

/**
* 
*/
class CommentDataAccess
{
	/**
	 * 获取文章评论
	 * @Author   Lerko
	 * @DateTime 2017-04-16T11:53:01+0800
	 * @param    [type]                   $aid [description]
	 * @return   [type]                        [description]
	 */
	public static function getCommentByArticle($aid)
	{
		$CommentEntity=new CommentEntity();
		$BlogCommon=$CommentEntity->whereEq("blog_id",$aid)->select();
		$data=[];
		$result=["data"=>[]];
		foreach ($BlogCommon as $key => $value) {
			$User=UserDataAccess::getUserInfoById($value['uid']);
			$data['__v']=0;
			$data['_id']=$value['id'];
			$data['aid']=$aid;
			$data['content']=$value['content'];
			$data['created']=Tool::getInstanct()->date_format_iso8601($value['create_time']);
			$RefCommon=self::getRefCommentList($value['id']);
			$replys=[];
			foreach ($RefCommon as $key_ref => $value_ref) {
				$replys[]=[
					"_id"=>$value_ref['id'],
					"content"=>$value_ref['content'],
					"created"=>Tool::getInstanct()->date_format_iso8601($value_ref['create_time']),
					"user_info"=>UserDataAccess::getSortUserInfo($value_ref['uid'])
				];
			}
			$data['replys']=$replys;
			$data['status']=1;
			$data['update']=Tool::getInstanct()->date_format_iso8601($value['update_time']);
			$data['user_id']=[
				"_id"=>$User['id'],
				"nickname"=>$User['username'],
				"avatar"=>"http://api-lerko.ngrok.cc/UploadFile/avatar.jpg"
			];
			$result['data'][]=$data;
		}
		return $result;
	}

	/**
	 * 找到关联的comment
	 * @Author   Lerko
	 * @DateTime 2017-04-16T11:59:47+0800
	 * @param    [type]                   $pid [description]
	 * @return   [type]                        [description]
	 */
	public static function getRefCommentList($pid)
	{
		$CommentEntity=new CommentEntity();
		return $CommentEntity->whereEq("ref_comment_id",$pid)->select();
	}
}
