<?php 
/**
 * @Author: lerko
 * @Date:   2017-03-27 16:55:01
 * @Last Modified by:   ‘chenyingqiao’
 * @Last Modified time: 2017-05-04 13:23:09
 */
namespace App\Controller;

use Jenssegers\Blade\Blade;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;
/**
* 
*/
class CommonController
{
	protected $blade;
	//初始化构造函数
	public function __construct(){
		//初始化blade模板引擎的师徒界面以及缓存界面
		$this->blade=new Blade("App/Controller/Editor/View","App/Controller/Editor/Cache");
		//设置页面时间格式化函数
		$this->blade->compiler()->directive('datetime', function ($expression) {
            return "<?php echo with({$expression})->format('F d, Y g:i a'); ?>";
        });
        //设置css js 等资源文件的引用路径处理函数
        $this->blade->compiler()->directive('UrlEditor', function ($url) {
            return "App/Controller/Editor/".$url;
        });
	}
}