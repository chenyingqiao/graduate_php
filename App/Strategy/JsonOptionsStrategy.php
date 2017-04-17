<?php 

use League\Route\Http\Exception\MethodNotAllowedException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\EmptyResponse;
/**
 * @Author: ‘chenyingqiao’
 * @Date:   2017-04-15 14:10:29
 * @Last Modified by:   ‘chenyingqiao’
 * @Last Modified time: 2017-04-15 14:17:12
 */

/**
* 
*/
class JsonOptionsStrategy extends JsonStrategy
{
	 /**
     * {@inheritdoc}
     */
    public function getMethodNotAllowedDecorator(MethodNotAllowedException $exception)
    {
        return function (ServerRequestInterface $request, ResponseInterface $response) use ($exception) {
        	if(strtolower($request->getMethod())=="options"){
        		return new EmptyResponse();
        	}
            return $exception->buildJsonResponse($response);
        };
    }
}