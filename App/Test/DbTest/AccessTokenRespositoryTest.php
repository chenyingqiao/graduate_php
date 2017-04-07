<?php 
/**
 * @Author: lerko
 * @Date:   2017-04-06 20:06:29
 * @Last Modified by:   ‘chenyingqiao’
 * @Last Modified time: 2017-04-07 23:22:47
 */
namespace App\Test\DbTest;

use App\Oauth\Db\AccessTokenEntity;
use App\Oauth\Repositories\AccessTokenRepository;
use PHPUnit\Framework\TestCase;
use Phero\System\DI;

class AccessTokenRespositoryTest extends TestCase
{

	/**
	 * [access_token_db_test description]
	 * @Author   Lerko
	 * @DateTime 2017-04-06T21:59:07+0800
	 * @return   [type]                   [description]
	 */
	// public function test_access_token_db()
	// {
	// 	DI::inj("all_config_path","/var/www/html/graduate_php/App/Config/phero_config.php");
	// 	$AccessTokenRespository=new AccessTokenRepository();
	// 	$accessTokenEntity=new AccessTokenEntity();
	// 	$accessTokenEntity->client="11111111111111";
	// 	$accessTokenEntity->expiry_time='2017-10-10';
	// 	$accessTokenEntity->user_id=1;
	// 	$accessTokenEntity->scope=12;
	// 	$accessTokenEntity->revoke=0;
	// 	$result=$AccessTokenRespository->persistNewAccessToken($accessTokenEntity);
	// 	echo $accessTokenEntity->sql();
	// 	echo $accessTokenEntity->error();
	// 	$this->assertEquals($result,$accessTokenEntity);
	// }

	/**
	 * 测试是否设置revoke成功
	 * @Author   Lerko
	 * @DateTime 2017-04-07T22:47:56+0800
	 * @return   [type]                   [description]
	 */
	// public function test_revoke_access_token(){
	// 	DI::inj("all_config_path","/var/www/html/graduate_php/App/Config/phero_config.php");
	// 	$AccessTokenRespository=new AccessTokenRepository();
	// 	$accessTokenEntity=new AccessTokenEntity();
	// 	$id=$AccessTokenRespository->revokeAccessToken(1);
	// 	$this->assertEquals($id,1);
	// }

	public function test_revoke_access_token(){
		DI::inj("all_config_path","/var/www/html/graduate_php/App/Config/phero_config.php");
		$AccessTokenRespository=new AccessTokenRepository();
		$accessTokenEntity=new AccessTokenEntity();
		$id=$AccessTokenRespository->isAccessTokenRevoked(1);
		$this->assertEquals($id,0);
	}
}