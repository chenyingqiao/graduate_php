<?php 
/**
 * @Author: lerko
 * @Date:   2017-03-27 13:46:27
 * @Last Modified by:   lerko
 * @Last Modified time: 2017-03-27 17:17:36
 */
require "vendor/autoload.php";

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use League\Route\Strategy as strategy;
use Zend\Diactoros\Response as ZendResponse;

$container = new League\Container\Container;

$container->share('response', Zend\Diactoros\Response::class);
$container->share('request', function () {
    return Zend\Diactoros\ServerRequestFactory::fromGlobals(
        $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
    );
});

$container->share('emitter', Zend\Diactoros\Response\SapiEmitter::class);

$route = new League\Route\RouteCollection($container);

$route->map('GET', '/', function (ServerRequestInterface $request, ResponseInterface $response) {
    $response->getBody()->write('<h1>Hello, World!</h1>');
    return $response;
});

$route->map('GET', '/user/{id:number}/{name}', function (ServerRequestInterface $request, ResponseInterface $response,array $args) {
	var_dump($args);
    $response->getBody()->write("<h1>Hello, World! /user/");
    return $response;
})->setStrategy(new strategy\ApplicationStrategy());

$route->map('GET', '/user/{id:number}/{name}', function (ServerRequestInterface $request, ResponseInterface $response,array $args) {
	var_dump($args);
    $response->getBody()->write("<h1>Hello, World! /user/");
    return $response;
})->setStrategy(new strategy\ApplicationStrategy());

$response = $route->dispatch($container->get('request'), $container->get('response'));

$container->get('emitter')->emit($response);