<?php 
/**
 * @Author: ‘chenyingqiao’
 * @Date:   2017-04-15 13:59:13
 * @Last Modified by:   ‘chenyingqiao’
 * @Last Modified time: 2017-04-15 14:44:31
 */

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\EmptyResponse;

/**
* 对options的操作进行过滤
*/
class OptionsMethodMiddleware
{
	public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
	{
		$method=strtolower($request->getMethod());
		if($method=='options'){
			return new EmptyResponse();
		}
		return $next($request,$response);
	}
}