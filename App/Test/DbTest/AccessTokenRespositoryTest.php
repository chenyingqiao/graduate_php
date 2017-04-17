<?php 
/**
 * @Author: lerko
 * @Date:   2017-04-06 20:06:29
 * @Last Modified by:   ‘chenyingqiao’
 * @Last Modified time: 2017-04-09 17:48:26
 */
namespace App\Test\DbTest;

use App\Model\UserEntity;
use App\Oauth\Db\AccessTokenEntity;
use App\Oauth\Db\ClientEntity;
use App\Oauth\Repositories\AccessTokenRepository;
use PHPUnit\Framework\TestCase;
use Phero\System\DI;

class AccessTokenRespositoryTest extends TestCase
{

	/**
	 * [access_token_db_test description]
	 * @Author   Lerko
	 * @codeCoverageIgnore
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

	// public function test_is_revoke_access_token(){
	// 	DI::inj("all_config_path","/var/www/html/graduate_php/App/Config/phero_config.php");
	// 	$AccessTokenRespository=new AccessTokenRepository();
	// 	$accessTokenEntity=new AccessTokenEntity();
	// 	$id=$AccessTokenRespository->isAccessTokenRevoked(1);
	// 	$this->assertEquals($id,0);
	// }

	// public function test_create_user()
	//  {
	// 	DI::inj("all_config_path","/var/www/html/graduate_php/App/Config/phero_config.php");
	// 	$userEntity=new UserEntity();
	// 	$userEntity->username="test1";
	// 	$userEntity->password=password_hash("111111",PASSWORD_DEFAULT);
	// 	$userEntity->create_time=time();
	// 	$userEntity->update_time=time();
	// 	$userEntity->head_image="https://avatars2.githubusercontent.com/u/8207331?v=3&s=460";
	// 	$userEntity->sex=1;
	// 	echo "==========";
	// 	$effect=$userEntity->insert();
	// 	echo $userEntity->error();
	// 	echo $userEntity->sql();
	// 	var_dump($effect);
	// 	$this->assertEquals($effect,true);
	//  } 
	//  
	
	public function test_create_user()
	 {
		DI::inj("all_config_path","/var/www/html/graduate_php/App/Config/phero_config.php");
		$clientEntity=new ClientEntity();
		$clientEntity->name="test_client_1";
		$clientEntity->redirect_url="http://www.baidu.com";
		$clientEntity->secret=password_hash("111111",PASSWORD_DEFAULT);
		$clientEntity->is_confidential=1;
		$effect=$clientEntity->insert();
		echo $clientEntity->error();
		echo $clientEntity->sql();
		var_dump($effect);
		$this->assertEquals($effect,true);
	 } 
}