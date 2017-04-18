<?php 
/**
 * @Author: lerko
 * @Date:   2017-03-27 13:46:27
 * @Last Modified by:   ‘chenyingqiao’
 * @Last Modified time: 2017-04-17 21:20:33
 */
require "vendor/autoload.php";

use App\Controller as Controller;
use App\Controller\Route\MyRoute;
use App\Model\UserEntity;
use League\Route\Strategy as Strategy;
use Phero\System\DI;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response as ZendResponse;

DI::inj("all_config_path",__DIR__."/App/Config/phero_config.php");
$myRoute=new MyRoute($route);
$myRoute->Common();
$myRoute->Oauth();
$myRoute->User();
$myRoute->Article();
$myRoute->Comment();
$myRoute->Editor();
$myRoute->dispatch();
