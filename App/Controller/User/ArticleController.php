<?php 
/**
 * @Author: ‘chenyingqiao’
 * @Date:   2017-04-15 14:49:28
 * @Last Modified by:   ‘chenyingqiao’
 * @Last Modified time: 2017-04-18 08:14:21
 */
namespace App\Controller\User;

use App\Model\BlogEntity;
use App\Model\DataAccess\ArticleDataAccess;
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
		$data['user_id']=$request->getAttribute("user_id");
		$effect=ArticleDataAccess::addArticle($data);
		if($effect[0]){
			return new JsonResponse([
					"msg"=>"",
					"status"=>true,
					"id"=>ArticleDataAccess::getIdByTitle($data['title'])
				]);
		}else{
			return new JsonResponse([
					"msg"=>$effect[1],
					"status"=>false,
					"id"=>-1
				]);
		}
		return new JsonResponse(["error_msg"=>"添加出错".$Blog->error()],422);
	}

	/**
	 * 删除文章
	 * @Author   Lerko
	 * @DateTime 2017-04-18T08:14:17+0800
	 * @param    ServerRequestInterface   $request  [description]
	 * @param    ResponseInterface        $response [description]
	 * @param    array                    $args     [description]
	 * @return   [type]                             [description]
	 */
	public function deleteArticle(ServerRequestInterface $request,ResponseInterface $response,array $args){
		$effect=ArticleDataAccess::deleteArticle($args['aid']);
		if($effect){
			return new JsonResponse(['msg'=>"删除成功","status"=>false]);
		}
		return new JsonResponse(['msg'=>"删除失败","status"=>true],422);
	}

}