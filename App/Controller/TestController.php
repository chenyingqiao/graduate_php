<?php 
/**
 * @Author: lerko
 * @Date:   2017-03-27 16:55:01
 * @Last Modified by:   lerko
 * @Last Modified time: 2017-03-29 15:07:59
 */
namespace App\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;
/**
* 
*/
class TestController
{
	public function test(ServerRequestInterface $request,ResponseInterface $response,array $args)
	{
		$response=new JsonResponse([
				"asdf"=>11,
				"asdf2"=>11,
			]);
		return $response;
	}
}