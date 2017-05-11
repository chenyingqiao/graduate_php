<?php 

namespace App\Controller\Editor;

use App\Controller\CommonController;
use App\Model\BlogEntity;
use App\Model\CatEntity;
use App\Model\ImageBlogRef;
use App\Model\ImageWarehouse;
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
 * @Last Modified by:   ‘chenyingqiao’
 * @Last Modified time: 2017-05-03 18:24:58
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
		$webPath="http://api-lerko.ngrok.cc";
		$blog_id=$request->getParsedBody()['blog_id'];
		try {
			$upload=$request->getUploadedFiles()["editormd-image-file"];
			$prex=Tool::getInstanct()->getUploadFilePrex($upload->getClientFilename());
			$resultPath=DIRECTORY_SEPARATOR."UploadFile".DIRECTORY_SEPARATOR.time()."blog".rand(1000,9999);
			$addPrexPath=$resultPath.".".$prex;
			$filepath=__ROOT__.$addPrexPath;
			$upload->moveTo($filepath);
			//图片略缩图
			Tool::getInstanct()->img2thumb($filepath,__ROOT__.$resultPath."small".".".$prex);
			$this->saveImageInfo($blog_id,$webPath.$addPrexPath,$webPath.$resultPath."small".".".$prex);//保存图片信息到数据库
			return new JsonResponse([
					"success" => 1,
				    "message" => "上传成功",
				    "url"     => $webPath.$addPrexPath
				]);
		} catch (Exception $e) {
			return new JsonResponse([
					"success" => 0,
				    "message" => "上传失败"
				]);
		}

	}

	/**
	 * 保存图片信息
	 * @Author   Lerko
	 * @DateTime 2017-05-02T17:57:34+0800
	 * @param    [type]                   $blog_id [description]
	 * @param    [type]                   $url     [description]
	 * @param    [type]                   $cut_url [description]
	 * @return   [type]                            [description]
	 */
	private function saveImageInfo($blog_id,$url,$cut_url){
		$imageWarehouse=new ImageWarehouse();
		$imageWarehouse->image_path=$url;
		$imageWarehouse->image_cut_path=$cut_url;
		$imageWarehouse->create_time=time();
		$imageWarehouse->update_time=time();
		$imageWarehouse->insert();
		$image_id=$imageWarehouse->getLastId();

		$imageBlogRef=new ImageBlogRef();
		$imageBlogRef->blog_id=$blog_id;
		$imageBlogRef->image_id=$image_id;
		$imageBlogRef->create_time=time();
		$imageBlogRef->update_time=time();
		$imageBlogRef->insert();
	}
}