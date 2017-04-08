<?php 
/**
 * @Author: ‘chenyingqiao’
 * @Date:   2017-04-08 13:13:48
 * @Last Modified by:   ‘chenyingqiao’
 * @Last Modified time: 2017-04-08 15:07:16
 */
namespace App\Controller\Route;

use App\Controller\Oauth\OauthController;
use League\Container\Container;
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
		$this->route = new RouteCollection($this->container);;
	}

	public function Common(){
		$this->route->map('GET', '/', function (ServerRequestInterface $request, ResponseInterface $response) {
		    $response->getBody()->write('<h1>Hello, World121212!</h1>');
		    return $response;
		});

		$this->route->map('GET', '/user', function (ServerRequestInterface $request, ResponseInterface $response,array $args) {
		    $response->getBody()->write("Hello, World! /user/");
		    return $response;
		})->setStrategy(new ApplicationStrategy());
	}

	public function Oauth(){
		$OauthController=new OauthController();
		$this->route->post("/user/oauth",[$OauthController,'passwordOauth'])->setStrategy(new JsonStrategy);
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
