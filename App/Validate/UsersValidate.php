<?php 
namespace App\Validate;

use Psr\Http\Message\ServerRequestInterface;
/**
 * @Author: ‘chenyingqiao’
 * @Date:   2017-04-15 10:07:29
 * @Last Modified by:   ‘chenyingqiao’
 * @Last Modified time: 2017-04-15 17:03:38
 */
class UsersValidate
{
	//注册验证
	public function validate_register(ServerRequestInterface $request)
	{
		$data=$request->getParsedBody();
		if(!empty($data['username'])&&!empty($data['password'])&&!empty($data['password_re'])){
			if($data['password']!=$data['password_re']){
				return [false,"两个密码不匹配"];
			}
			return [true];
		}
		return [false,"用户名或者注册密码为空"];
	}
}