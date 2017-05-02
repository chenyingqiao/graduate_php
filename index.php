<?php 
/**
 * @Author: lerko
 * @Date:   2017-03-27 13:46:27
 * @Last Modified by:   ‘chenyingqiao’
 * @Last Modified time: 2017-05-01 15:09:11
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

error_reporting(E_ERROR);
define("__ROOT__", __DIR__);
DI::inj("all_config_path",__DIR__."/App/Config/phero_config.php");
$myRoute=new MyRoute($route);
$myRoute->Common();
$myRoute->Oauth();
$myRoute->User();
$myRoute->Article();
$myRoute->Comment();
$myRoute->Editor();
$myRoute->Tags();
$myRoute->dispatch();
