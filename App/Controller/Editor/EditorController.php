<?php 

namespace App\Controller\Editor;

use App\Controller\CommonController;
use App\Model\BlogEntity;
use Jenssegers\Blade\Blade;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\TextResponse;
/**
 * @Author: ‘chenyingqiao’
 * @Date:   2017-04-17 20:08:28
 * @Last Modified by:   ‘chenyingqiao’
 * @Last Modified time: 2017-04-17 22:47:28
 */

/**
* 
*/
class EditorController extends CommonController
{
	public function editormd(ServerRequestInterface $request,ResponseInterface $response,array $args)
	{
		$query=$request->getQueryParams();
		$Blog=new BlogEntity();
		if(isset($query['aid'])){
			$md=$Blog->whereEq("id",$query['aid'])->find("markdown");
			if(empty($md)){
				$md="# 标题";
				$query['aid']=-1;
			}
		}
		else{
			$md="# 标题";
			$query['aid']=-1;
		}
		if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=="xmlhttprequest"){ 
			return new TextResponse($md);
		}
		$html=$this->blade->make("index",[
				"aid"=>$query['aid'],
				"md"=>$md
			])->render();
		return new HtmlResponse($html);
	}
}