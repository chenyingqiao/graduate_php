<?php 
/**
 * @Author: ‘chenyingqiao’
 * @Date:   2017-04-08 10:06:35
 * @Last Modified by:   ‘chenyingqiao’
 * @Last Modified time: 2017-04-08 11:28:22
 */
namespace App\Test\DbTest;

use App\Oauth\Db\AccessTokenEntity;
use PHPUnit\Framework\TestCase;
use Phero\System\DI;

/**
* 
*/
class DbTest extends TestCase
{	
	public function test_select()
	{
		DI::inj("all_config_path","/var/www/html/graduate_php/App/Config/phero_config.php");
		$access_token=new AccessTokenEntity();
		$result=$access_token->select();
		// var_dump($result[0]->id);
		var_dump($result[0]['id']);
	}
}