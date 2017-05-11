<?php 
/**
 * @Author: ‘chenyingqiao’
 * @Date:   2017-04-15 14:49:28
 * @Last Modified by:   ‘chenyingqiao’
 * @Last Modified time: 2017-05-09 08:30:51
 */
namespace App\Controller\User;

use App\Model\BlogEntity;
use App\Model\CatEntity;
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
		$id=rand(1,3);
		return new JsonResponse([
				"img"=>"http://api-lerko.ngrok.cc/UploadFile/{$id}.jpg",
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
		$currentPage=$queryParam["currentPage"];
		$itemsPerPage=$queryParam["itemsPerPage"];
		$sortName=$queryParam["sortName"];
		$key_word=$queryParam['key_word'];
		$tagId=$queryParam['tagId'];
		if($sortName=="publish_time"){
			$sortName="create_time";
		}elseif($sortName=='my'){
			$sortName='update_time';
		}
		else{
			$sortName="visit_count";
		}
		$Blog=new BlogEntity();
		$entity=Tool::getInstanct()->Page($Blog,$currentPage,$itemsPerPage);
		if($key_word) {
			// $userEntity=new UserEntity();
			// $userEntity->whereEq('id','blog.id');
			$entity->whereLike("title",'%'.$key_word.'%')
			->whereOrLike("markdown",'%'.$key_word.'%');
			// ->whereOrExists("user.username",$userEntity);
		}
		if($sortName=='update_time'&&empty($request->getAttribute("user_id"))){
			return new JsonResponse(["data"=>[]]);
		} 
		if($sortName=='update_time') $entity->whereEq('uid',$request->getAttribute("user_id"));
		if(isset($tagId)&&!empty($tagId))
			$entity->whereEq("tag_id",$tagId);
		$data=$entity->order($sortName,"DESC")->select();
		$xdebug_sql=$entity->sql();
		$result=["data"=>[]];
		foreach ($data as $key => $value) {
			$result["data"][]=[
				"_id"=>$value['id'],
				"title"=>$value['title'],
				"publish_time"=>Tool::getInstanct()->date_format_iso8601($value['create_time']),
				"like_count"=>$value['like'],
				"comment_count"=>rand(1,50),
				"visit_count"=>$value['visit_count'],
				"images"=>ArticleDataAccess::getImageList($value['id']),
				"uid"=>$value['uid']
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
		if(!empty($prev)){
			$prev=[
				"_id"=>$prev['id'],
				"title"=>$prev['title']
			];
		}
		$next=$Blog->whereEq("id",$args['id']+1)->find();
		if(!empty($next)){
			$next=[
				"_id"=>$next['id'],
				"title"=>$next['title']
			];
		}
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
	//获取文章详细信息
	public function getFrontArticle(ServerRequestInterface $request,ResponseInterface $response,array $args)
	{
		$Blog=new BlogEntity();
		$data=$Blog->whereEq("id",$args['id'])->find();
		$Blog->visit_count=$data['visit_count']+1;
		$Blog->whereEq("id",$args['id'])->update();
		return new JsonResponse([
				"data"=>[
					"_id"=>$data['id'],
					"title"=>$data['title'],
					"publish_time"=>Tool::getInstanct()->date_format_iso8601($data['create_time']),
					"like_count"=>$data['like'],
					"visit_count"=>$Blog->visit_count,
					"comment_count"=>rand(1,50),
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
					"id"=>$data['id']
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
			return new JsonResponse(['msg'=>"删除成功","status"=>true]);
		}
		return new JsonResponse(['msg'=>"删除失败","status"=>false],422);
	}

	/**
	 * {"success":true,"count":7,"isLike":true}
	 * @Author   Lerko
	 * @DateTime 2017-04-18T22:36:24+0800
	 * @param    ServerRequestInterface   $request  [description]
	 * @param    ResponseInterface        $response [description]
	 * @param    array                    $args     [description]
	 * @return   [type]                             [description]
	 */
	public function toggleLike(ServerRequestInterface $request,ResponseInterface $response,array $args)
	{
		$data['user_id']=$request->getAttribute("user_id");
		$effect=ArticleDataAccess::like($args['aid'],$data['user_id']);
		if(!empty($effect)){
			return new JsonResponse(['count'=>$effect,"success"=>true,"isLike"=>true]);
		}
		return new JsonResponse(['count'=>$effect,"success"=>false,"isLike"=>false],422);
	}

	/**
	 * 获取标签
	 * @Author   Lerko
	 * @DateTime 2017-04-23T21:35:24+0800
	 * @param    ServerRequestInterface   $request  [description]
	 * @param    ResponseInterface        $response [description]
	 * @param    array                    $args     [description]
	 * @return   [type]                             [description]
	 */
	public function getFrontTagList(ServerRequestInterface $request,ResponseInterface $response,array $args)
	{
		$cat=new CatEntity();
		$data=$cat->select();
		return new JsonResponse([
				"data"=>$data
			]);
	}

}