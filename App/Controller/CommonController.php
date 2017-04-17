<?php 
/**
 * @Author: lerko
 * @Date:   2017-03-27 16:55:01
 * @Last Modified by:   ‘chenyingqiao’
 * @Last Modified time: 2017-04-17 21:13:14
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
	public function __construct(){
		$this->blade=new Blade("App/Controller/Editor/View","App/Controller/Editor/Cache");
		$this->blade->compiler()->directive('datetime', function ($expression) {
            return "<?php echo with({$expression})->format('F d, Y g:i a'); ?>";
        });
        $this->blade->compiler()->directive('UrlEditor', function ($url) {
            return "App/Controller/Editor/".$url;
        });
	}
}