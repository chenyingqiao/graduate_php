<?php 
/**
 * @Author: ‘chenyingqiao’
 * @Date:   2017-04-08 13:13:48
 * @Last Modified by:   ‘chenyingqiao’
 * @Last Modified time: 2017-04-30 10:09:53
 */
namespace App\Controller\Route;

use App\Controller\Editor\EditorController;
use App\Controller\Oauth\OauthController;
use App\Controller\User\ArticleController;
use App\Controller\User\CommentController;
use App\Controller\User\UserController;
use App\Middleware\JsonRequestBodyDecodeMiddleware;
use App\Middleware\OptionsMethodMiddleware;
use App\Middleware\UserLoginMiddleware;
use App\Middleware\ValidateMiddleware;
use App\Oauth\Repositories\AccessTokenRepository;
use League\Container\Container;
use League\OAuth2\Server\Middleware\ResourceServerMiddleware;
use League\OAuth2\Server\ResourceServer;
use League\Route\RouteCollection;
use League\Route\Strategy\ApplicationStrategy;
use League\Route\Strategy\JsonStrategy;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Tuupola\Middleware\Cors;
use Zend\Diactoros\Response;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\Response\SapiEmitter;
use Zend\Diactoros\ServerRequestFactory;

/**
* middleware执行顺序是从下网上执行
*/
class MyRoute
{
	private $route;
	private $container;
	private $corsSetting;
	
	public function __construct(&$route)
	{
		$this->container = new Container;
		$this->container->share("resourceServer",function () {
	        $publicKeyPath = 'file://' . dirname(__DIR__) . '/Oauth/key/public.key';

	        $server = new ResourceServer(
	            new AccessTokenRepository(),
	            $publicKeyPath
	        );
	        return $server;
    	});
    	$this->corsSetting=[
		    "origin" => ["*"],
		    "methods" => ["GET", "POST", "PUT", "PATCH", "DELETE","OPTIONS"],
		    "headers.allow" => ["content-type","authorization"],
		    "headers.expose" => [],
		    "credentials" => true,
		    "cache" => 0,
		];
		$this->route = new RouteCollection($this->container);
	}

	/**
	 * 公共url
	 * @Author   Lerko
	 * @DateTime 2017-04-08T21:53:53+0800
	 */
	public function Common(){
		$this->route->map('GET', '/', function (ServerRequestInterface $request, ResponseInterface $response) {
		 	$response = new HtmlResponse("<h1 style='margin:0 auto'>欢迎来到BlogApi</h1>");
		    return $response;
		});
	}

	/**
	 * oauth2.0服务器验证
	 * @Author   Lerko
	 * @DateTime 2017-04-09T13:37:21+0800
	 */
	public function Oauth(){
		$UserController=new UserController();
		$OauthController=new OauthController();
		$this->route->group('/auth',function($route) use ($OauthController,$UserController){
			$route->map(['POST',"OPTIONS"],"/local",[$OauthController,'passwordOauth']);
			$route->map(["POST","OPTIONS"],"/register",[$UserController,'register']);
		})->setStrategy(new JsonStrategy)
		->middleware(new JsonRequestBodyDecodeMiddleware())
		->middleware(new OptionsMethodMiddleware())
		->middleware(new Cors($this->corsSetting));
		
	}

	public function User()
	{
		$OauthController=new OauthController();
		$UserController=new UserController();
		$this->route->group('/users',function($route) use ($OauthController,$UserController){
			$route->map(["GET","OPTIONS"],"/snsLogins",[$OauthController,'snsLogins']);
			$route->map(["GET","OPTIONS"],"/me",[$UserController,'me']);
		})->setStrategy(new JsonStrategy)
		->middleware(new ValidateMiddleware())
		->middleware(new JsonRequestBodyDecodeMiddleware())
		->middleware(new OptionsMethodMiddleware())
		->middleware(new Cors($this->corsSetting));//Cors中间件
	}

	public function Article(){
		$ArticleController=new ArticleController();
		$this->route->group('/article',function($route) use ($ArticleController){
			$route->map(["GET","OPTIONS"],"/getIndexImage",[$ArticleController,"getIndexImage"]);
			$route->map(["GET","OPTIONS"],"/getFrontArticleList",[$ArticleController,"getFrontArticleList"]);
			//获取下一个文章的标题
			$route->map(["GET","OPTIONS"],"/{id:number}/getPrenext",[$ArticleController,"getPrenext"]);
			//获取文章详细内容
			$route->map(["GET","OPTIONS"],"/{id:number}/getFrontArticle",[$ArticleController,"getFrontArticle"]);
			$route->map(["POST","OPTIONS"],"/addArticle",[$ArticleController,"addArticle"]);
			$route->map(["DELETE","OPTIONS"],"/{aid:number}/deleteArticle",[$ArticleController,"deleteArticle"]);
			$route->map(["PUT","OPTIONS"],"/{aid:number}/toggleLike",[$ArticleController,"toggleLike"]);
		})->setStrategy(new JsonStrategy)
		->middleware(new ValidateMiddleware())
		->middleware(new JsonRequestBodyDecodeMiddleware())
		->middleware(new OptionsMethodMiddleware())
		->middleware(new Cors($this->corsSetting));//Cors中间件
	}

	public function Comment(){
		$CommentController=new CommentController();
		$this->route->group("/comment",function($route) use ($CommentController){
			$route->map(["POST","OPTIONS"],"/addNewComment",[$CommentController,"addNewComment"]);
			//获取评论列表
			$route->map(["GET","OPTIONS"],"/{aid:number}/getFrontCommentList",[$CommentController,"getFrontCommentList"]);
			$route->map(["POST","OPTIONS"],"/{comment_id:number}/addNewReply",[$CommentController,"addNewReply"]);
		})->setStrategy(new JsonStrategy)
		->middleware(new ValidateMiddleware())
		->middleware(new JsonRequestBodyDecodeMiddleware())
		->middleware(new OptionsMethodMiddleware())
		->middleware(new Cors($this->corsSetting));
	}

	public function Editor()
	{
		$EditorController=new EditorController();
		$this->route->map('GET',"/editor",[$EditorController,"editormd"]);
		//文件上传
		$this->route->map(['POST'],'/fileupload',[$EditorController,"fileupload"])->setStrategy(new JsonStrategy);
	}

	public function Tags(){
		$ArticleController=new ArticleController();
		$this->route->map(["GET","OPTIONS"],"/tags/getFrontTagList",[$ArticleController,"getFrontTagList"])
		->setStrategy(new JsonStrategy)
		->middleware(new ValidateMiddleware())
		->middleware(new JsonRequestBodyDecodeMiddleware())
		->middleware(new OptionsMethodMiddleware())
		->middleware(new Cors($this->corsSetting));
	}

	public function dispatch(){
		$this->container->share('response', Response::class);
		$this->container->share('request', function () {
		    return ServerRequestFactory::fromGlobals(
		        $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
		    );
		});
		$this->container->share('emitter', SapiEmitter::class);
		$response = $this->route->dispatch($this->container->get('request'), $this->container->get('response'));

		$this->container->get('emitter')->emit($response);
	}
}
