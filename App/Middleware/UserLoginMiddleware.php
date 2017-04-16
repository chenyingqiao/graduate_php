<?php 
/**
 * @Author: ‘chenyingqiao’
 * @Date:   2017-04-16 14:37:39
 * @Last Modified by:   ‘chenyingqiao’
 * @Last Modified time: 2017-04-16 14:41:04
 */

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

/**
 * 检查是否登陆了，并且正常的获取到了用户信息
 */
class UserLoginMiddleware{
	public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
	{
		$UserId=$request->getAttribute("user_id");
		if(empty($UserId)){
			return new JsonResponse(["error_msg"=>"无法获取用户数据"],422);
		}
		return $next($request,$response);
	}
}
