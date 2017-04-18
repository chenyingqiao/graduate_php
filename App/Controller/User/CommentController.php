<?php 

namespace App\Controller\User;

use App\Model\CommentEntity;
use App\Model\DataAccess\CommentDataAccess;
use App\Model\DataAccess\UserDataAccess;
use App\Model\UserEntity;
use App\Tool\Tool;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;
/**
 * @Author: ‘chenyingqiao’
 * @Date:   2017-04-15 21:25:40
 * @Last Modified by:   ‘chenyingqiao’
 * @Last Modified time: 2017-04-17 22:57:13
 */

/**
* 
*/
class CommentController
{
	/**
	 * aid是文章id
	 * {"aid":"57fe40feed269300192dd947","content":"速度发送对方"}
	 * {"success":true,"data":{"__v":0,"aid":"57fe40feed269300192dd947","content":"速度发送对方","user_id":{"_id":"58e99fa1caf4d80201952551","nickname":"chenyingqiao121","avatar":"https://avatars2.githubusercontent.com/u/8207331?v=3"},"_id":"58f21e98caf4d80201952556","updated":"2017-04-15T13:22:32.054Z","created":"2017-04-15T13:22:32.054Z","status":1,"replys":[]}}
	 * @Author   Lerko
	 * @DateTime 2017-04-15T21:26:15+0800
	 * @param    string                   $value [description]
	 */
	public function addNewComment(ServerRequestInterface $request,ResponseInterface $response,array $args)
	{
		$param=$request->getParsedBody();
		$UserId=$request->getAttribute("user_id");
		$User=UserDataAccess::getUserInfoById($UserId);
		$CommentEntity=new CommentEntity();
		$CommentEntity->blog_id=$param["aid"];
		$CommentEntity->content=$param['content'];
		$CommentEntity->create_time=time();
		$CommentEntity->update_time=time();
		$CommentEntity->uid=$User["id"];
		$effect=$CommentEntity->insert();
		if($effect){
			return new JsonResponse([
					"success"=>true,
					"data"=>[
						"__v"=>0,
						"_id"=>$CommentEntity->getLastId(),
						"aid"=>$param['aid'],
						"content"=>$param['content'],
						"created"=>Tool::getInstanct()->date_format_iso8601($CommentEntity->create_time),
						"replys"=>[],
						"status"=>1,
						"updated"=>Tool::getInstanct()->date_format_iso8601($CommentEntity->update_time),
						"user_id"=>[
							"_id"=>$User['id'],
							"nickname"=>$User['username'],
							"avatar"=>"http://api-lerko.ngrok.cc/UploadFile/avatar.jpg"
						]
					]
				]);
		}else{
			return new JsonResponse(["error_msg"=>"评论失败"],422);
		}
	}


	/**
	 * [getFrontCommentList description]
	 * @Author   Lerko
	 * @DateTime 2017-04-15T21:35:57+0800
	 * @param    ServerRequestInterface   $request  [description]
	 * @param    ResponseInterface        $response [description]
	 * @param    array                    $args     [description]
	 * @return   [type]                             [description]
	 */
	public function getFrontCommentList(ServerRequestInterface $request,ResponseInterface $response,array $args)
	{
		$data=CommentDataAccess::getCommentByArticle($args['aid']);
		return new JsonResponse($data);
	}

	public function addNewReply(ServerRequestInterface $request,ResponseInterface $response,array $args)
	{
		$param=$request->getParsedBody();
		$CommentEntity=new CommentEntity();
		$CommentEntity->content=$param['content'];
		$CommentEntity->create_time=time();
		$CommentEntity->update_time=time();
		$CommentEntity->uid=$request->getAttribute("user_id");
		$CommentEntity->ref_comment_id=$args['comment_id'];
		$effect=$CommentEntity->insert();

		$refComment=CommentDataAccess::getRefCommentList($args["comment_id"]);
		$data=[];
		foreach ($refComment as $key => $value) {
			if(empty($value["uid"])){
				$data['data']=[];
				continue;
			}
			$data['data'][]=[
				"_id"=>$value["id"],
				"content"=>$value["content"],
				"created"=>Tool::getInstanct()->date_format_iso8601($value['create_time']),
				"user_info"=>UserDataAccess::getSortUserInfo($value['uid'])
			];
		}
		if($effect){
			$data['success']=true;
			return new JsonResponse($data);
		}else{
			return new JsonResponse(["error_msg"=>"添加评论失败"],422);
		}
	}
}