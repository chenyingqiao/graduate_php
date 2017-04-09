<?php 
/**
 * @Author: ‘chenyingqiao’
 * @Date:   2017-04-08 13:13:48
 * @Last Modified by:   ‘chenyingqiao’
 * @Last Modified time: 2017-04-08 22:08:24
 */
namespace App\Controller\Route;

use App\Controller\Oauth\OauthController;
use App\Oauth\Repositories\AccessTokenRepository;
use League\Container\Container;
use League\OAuth2\Server\Middleware\ResourceServerMiddleware;
use League\OAuth2\Server\ResourceServer;
use League\Route\RouteCollection;
use League\Route\Strategy\ApplicationStrategy;
use League\Route\Strategy\JsonStrategy;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\Response\SapiEmitter;
use Zend\Diactoros\ServerRequestFactory;

/**
* 
*/
class MyRoute
{
	private $route;
	private $container;
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
		$this->route = new RouteCollection($this->container);
	}

	/**
	 * 公共url
	 * @Author   Lerko
	 * @DateTime 2017-04-08T21:53:53+0800
	 */
	public function Common(){
		$this->route->map('GET', '/', function (ServerRequestInterface $request, ResponseInterface $response) {
		    $response->getBody()->write('<h1>Hello, World121212!</h1>');
		    return $response;
		});

		$this->route->map('GET', '/access_test', function (ServerRequestInterface $request, ResponseInterface $response,array $args) {
		    $response->getBody()->write("Hello, World! /user/");
		    return $response;
		})->setStrategy(new ApplicationStrategy())->middleware(new ResourceServerMiddleware($this->container->get("resourceServer")));

	}

	public function Oauth(){
		$OauthController=new OauthController();
		$this->route->group('/user',function($route) use ($OauthController){
			$route->post("/oauth",[$OauthController,'passwordOauth'])->setStrategy(new JsonStrategy);
		});
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
