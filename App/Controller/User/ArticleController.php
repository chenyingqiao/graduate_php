<?php 
/**
 * @Author: ‘chenyingqiao’
 * @Date:   2017-04-15 14:49:28
 * @Last Modified by:   ‘chenyingqiao’
 * @Last Modified time: 2017-04-16 11:34:30
 */
namespace App\Controller\User;

use App\Model\BlogEntity;
use App\Model\UserEntity;
use App\Tool\Tool;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

/**
* 文章控制器
*/
class ArticleController
{
	/**
	 * {"success":true,"img":"https://upload.jackhu.top/blog/index/dongshan002.jpg-600x1500q80"}
	 * @Author   Lerko
	 * @DateTime 2017-04-12T21:13:29+0800
	 * @param    string                   $value [description]
	 * @return   [type]                          [description]
	 */
	public function getIndexImage(ServerRequestInterface $request,ResponseInterface $response,array $args)
	{
		return new JsonResponse([
				"img"=>"https://upload.jackhu.top/blog/index/great-wall-201471_1280.jpg-600x1500q80",
				"success"=>true
			]);
	}

	/**
	 * https://api.jackhu.top/article/getFrontArticleList?currentPage=1&itemsPerPage=10&sortName=&tagId=55c969c066af1ad21c80701d
	 * {"data":[{"_id":"57fe40feed269300192dd947","title":"docker 实践杂记","publish_time":"2016-10-13T11:50:53.416Z","like_count":6,"comment_count":21,"visit_count":2587,"images":[]}]}
	 * @Author   Lerko
	 * @DateTime 2017-04-12T21:15:47+0800
	 * @return   [type]                   [description]
	 */
	public function getFrontArticleList(ServerRequestInterface $request,ResponseInterface $response,array $args){
		$queryParam=$request->getQueryParams();
		$currentPage=$request->getAttribute("currentPage");
		$itemsPerPage=$request->getAttribute("itemsPerPage");
		$Blog=new BlogEntity();
		$data=Tool::getInstanct()->Page($Blog,$currentPage,$itemsPerPage)->select();
		$result=[];
		foreach ($data as $key => $value) {
			$result["data"][]=[
				"_id"=>$value['id'],
				"title"=>$value['title'],
				"publish_time"=>"2016-10-13T11:50:53.416Z",
				"like_count"=>11,
				"comment_count"=>22,
				"images"=>[]
			];
		}
		return new JsonResponse($result);
	}

	/**
	 * 前置文章以及后置文章
	 * @Author   Lerko
	 * @DateTime 2017-04-15T18:28:22+0800
	 * @param    ServerRequestInterface   $request  [description]
	 * @param    ResponseInterface        $response [description]
	 * @param    array                    $args     [description]
	 * @return   [type]                             [description]
	 */
	public function getPrenext(ServerRequestInterface $request,ResponseInterface $response,array $args)
	{
		$Blog=new BlogEntity();
		$prev=$Blog->whereEq("id",$args['id']-1)->find();
		$prev=[
			"_id"=>$prev['id'],
			"title"=>$prev['title']
		];
		$next=$Blog->whereEq("id",$args['id']+1)->find();
		$next=[
			"_id"=>$next['id'],
			"title"=>$next['title']
		];
		return new JsonResponse([
				"data"=>[
					"next"=>$next,
					"prev"=>$prev
				]
			]);
	}


	/**
	 * 获取文章详细信息
	 * @Author   Lerko
	 * @DateTime 2017-04-16T09:27:51+0800
	 * @param    ServerRequestInterface   $request  [description]
	 * @param    ResponseInterface        $response [description]
	 * @param    array                    $args     [description]
	 * @return   [type]                             [description]
	 */
	public function getFrontArticle(ServerRequestInterface $request,ResponseInterface $response,array $args)
	{
		$Blog=new BlogEntity();
		$data=$Blog->whereEq("id",$args['id'])->find();
		return new JsonResponse([
				"data"=>[
					"_id"=>$data['id'],
					"title"=>$data['title'],
					"publish_time"=>"2016-10-13T11:50:53.416Z",
					"like_count"=>11,
					"comment_count"=>22,
					"content"=>$data['content']
				]
			]);
	}

	/**
	 * 添加文章
	 * @Author   Lerko
	 * @DateTime 2017-04-16T09:27:38+0800
	 * @param    ServerRequestInterface   $request  [description]
	 * @param    ResponseInterface        $response [description]
	 * @param    array                    $args     [description]
	 */
	public function addArticle(ServerRequestInterface $request,ResponseInterface $response,array $args)
	{
		$data=$request->getParsedBody();
		$Blog=new BlogEntity($data);
		$Blog->update_time=time();
		$Blog->create_time=time();
		$effect=$Blog->insert();
		if($effect){
			return new JsonResponse([
					"status"=>true
				]);
		}
		return new JsonResponse(["error_msg"=>"添加出错".$Blog->error()],422);
	}


}