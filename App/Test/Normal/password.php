<?php 
/**
 * @Author: ‘chenyingqiao’
 * @Date:   2017-04-09 15:59:29
 * @Last Modified by:   ‘chenyingqiao’
 * @Last Modified time: 2017-04-09 16:05:45
 */
namespace App\Test\Normal;

use PHPUnit\Framework\TestCase;

/**
* 
*/
class password extends TestCase
{
	public function test_password_hash()
	{
		$password_secret= password_hash("123456",PASSWORD_DEFAULT);
		$this->assertEquals(true,password_verify("123456",$password_secret));
	}
}