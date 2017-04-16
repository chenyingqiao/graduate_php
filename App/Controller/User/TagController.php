<?php 
/**
 * @Author: ‘chenyingqiao’
 * @Date:   2017-04-15 14:50:20
 * @Last Modified by:   ‘chenyingqiao’
 * @Last Modified time: 2017-04-15 14:52:17
 */
namespace App\Controller\User;

use App\Model\UserEntity;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

/**
* 获取Tag列表
*/
class TagController
{
	/**
	 * {"data":[{"_id":"57fb76abcf97d30019b941cf","name":"docker","cid":"55c9699166af1ad21c80701c","__v":0,"sort":1,"is_show":true,"is_index":true}]}
	 * @Author   Lerko
	 * @DateTime 2017-04-12T21:14:01+0800
	 * @return   [type]                   [description]
	 */
	public function getFrontTagList(ServerRequestInterface $request,ResponseInterface $response,array $args){
		
	}

}