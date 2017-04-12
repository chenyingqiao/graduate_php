<?php 

/**
 * @Author: ‘chenyingqiao’
 * @Date:   2017-04-11 20:50:05
 * @Last Modified by:   ‘chenyingqiao’
 * @Last Modified time: 2017-04-12 08:13:33
 */
namespace App\Middleware;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;


/**
* 
*/
class JsonRequestBodyDecodeMiddleware
{
	
	public function __invoke(RequestInterface $request, ResponseInterface $response, callable $next)
	{
		$jsonData=json_decode($request->getBody()->getContents(),true);
		if($jsonData===false){//不是json数据的话
			return $next($request,$response);
		}
        $request=$request->withParsedBody($jsonData);
        return $next($request,$response);
	}
}