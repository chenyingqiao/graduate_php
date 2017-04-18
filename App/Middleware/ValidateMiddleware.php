<?php 
/**
 * @Author: ‘chenyingqiao’
 * @Date:   2017-04-15 09:50:33
 * @Last Modified by:   ‘chenyingqiao’
 * @Last Modified time: 2017-04-15 17:00:54
 */
namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

class ValidateMiddleware
{
	
	public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
	{
		$uri=$request->getUri();
		$path=explode('/',$uri->getPath());
		$validate_name="App\\Validate\\".ucfirst($path[1])."Validate";
		$validate_fun="validate_".$path[count($path)-1];
		if(!class_exists($validate_name)){
			return $next($request,$response);
		}
		$validate=new $validate_name();
		if(!method_exists($validate,$validate_fun)){
			return $next($request,$response);
		}
		$result=$validate->$validate_fun($request);
		if($result[0])
			return $next($request,$response);
		else
			return new JsonResponse(["error_msg"=>$result[1]],422);
	}
}