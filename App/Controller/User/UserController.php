<?php 
/**
 * @Author: ‘chenyingqiao’
 * @Date:   2017-04-12 21:08:20
 * @Last Modified by:   ‘chenyingqiao’
 * @Last Modified time: 2017-04-15 14:51:58
 */
namespace App\Controller\User;

use App\Model\UserEntity;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

class UserController
{
	public function register(ServerRequestInterface $request,ResponseInterface $response,array $args)
	{
		$parsedBody=$request->getParsedBody();
		$UserEntity=new UserEntity();
		$UserEntity->username=$parsedBody['username'];
		$UserEntity->password=password_hash($parsedBody['password'],PASSWORD_DEFAULT);
		$effect=$UserEntity->insert();
		if($effect)
			return new JsonResponse();
		else
			return new JsonResponse(['error_msg'=>"注册失败"],422);
	}

	/**
	 * {"nickname":"chenyingqiao121","role":"user","avatar":"https://avatars2.githubusercontent.com/u/8207331?v=3","likes":[],"provider":"github"}
	 * @Author   Lerko
	 * @DateTime 2017-04-12T21:11:32+0800
	 * @param    string                   $value [description]
	 * @return   [type]                          [description]
	 */
	public function me(ServerRequestInterface $request,ResponseInterface $response,array $args)
	{
		$UserEntity=new UserEntity();
		$user_id=$request->getAttribute("user_id");
		$User=$UserEntity->whereEq("id",$request->getAttribute("user_id"))->find();
		if(!$User){
			return new JsonResponse(['error_msg'=>"获取用户信息失败"],422);
		}
		return new JsonResponse([
				"nickname"=>$User["username"],
				"role"=>"user",
				"avatar"=>"http://api-lerko.ngrok.cc/UploadFile/avatar.jpg",
				"likes"=>[],
				"provider"=>""
			]);
	}



}