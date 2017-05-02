<?php 

namespace App\Controller\Editor;

use App\Controller\CommonController;
use App\Model\BlogEntity;
use App\Model\CatEntity;
use App\Tool\Tool;
use Jenssegers\Blade\Blade;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\Response\TextResponse;
use Zend\Diactoros\UploadedFile;
/**
 * @Author: ‘chenyingqiao’
 * @Date:   2017-04-17 20:08:28
 * @Last Modified by:   lerko
 * @Last Modified time: 2017-05-02 17:30:09
 */

/**
* 
*/
class EditorController extends CommonController
{
	public function editormd(ServerRequestInterface $request,ResponseInterface $response,array $args)
	{
		$tag=new CatEntity();
		$tags=$tag->select();

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
				"md"=>$md,
				"tags"=>$tags
			])->render();
		return new HtmlResponse($html);
	}

	public function fileupload(ServerRequestInterface $request,ResponseInterface $response,array $args)
	{
		try {
			$upload=$request->getUploadedFiles()["editormd-image-file"];
			$prex=Tool::getInstanct()->getUploadFilePrex($upload->getClientFilename());
			$resultPath=DIRECTORY_SEPARATOR."UploadFile".DIRECTORY_SEPARATOR.time()."blog".rand(1000,9999);
			$addPrexPath=$resultPath.".".$prex;
			$filepath=__ROOT__.$addPrexPath;
			$upload->moveTo($filepath);
			//图片略缩图
			Tool::getInstanct()->img2thumb($filepath,__ROOT__.$resultPath."small".".".$prex);
			return new JsonResponse([
					"success" => 1,
				    "message" => "上传成功",
				    "url"     => $addPrexPath
				]);
		} catch (Exception $e) {
			return new JsonResponse([
					"success" => 0,
				    "message" => "上传失败"
				]);
		}

	}
}