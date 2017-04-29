<?php 

/**
 * @Author: ‘chenyingqiao’
 * @Date:   2017-04-11 20:50:05
 * @Last Modified by:   ‘chenyingqiao’
 * @Last Modified time: 2017-04-22 14:30:30
 */
namespace App\Middleware;

use App\Oauth\Db\AccessTokenEntity;
use Lcobucci\JWT\Parser;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;


/**
* 
*/
class JsonRequestBodyDecodeMiddleware
{
	
	public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
	{
		$content=$request->getBody()->getContents();
		$jsonData=json_decode($content,true);
		//获取user_id
		if($request->hasHeader('authorization')){
			$header = $request->getHeader('authorization');
        	$jwt = trim(preg_replace('/^(?:\s+)?Bearer\s/', '', $header[0]));
			$token = (new Parser())->parse($jwt)->getClaim('jti');//从加密string中获取token
			$AccessTokenEntity=new AccessTokenEntity();
			$user_id=$AccessTokenEntity->whereEq("access_token_id",$token)->find("user_id");
			if(empty($user_id)){
				return new JsonResponse(["error_msg"=>"用户不存在"],422);
			}
			$request=$request->withAttribute("user_id",$user_id);
		}
		if(empty($jsonData)){//不是json数据的话
			return $next($request,$response);
		}
		$body= $request->getParsedBody();
		$jsonData=array_merge($body,$jsonData);
        $request=$request->withParsedBody($jsonData);
        return $next($request,$response);
	}
}