<?php 
/**
 * @Author: ‘chenyingqiao’
 * @Date:   2017-04-16 11:49:10
 * @Last Modified by:   ‘chenyingqiao’
 * @Last Modified time: 2017-04-16 15:40:26
 */

namespace App\Model\DataAccess;

use App\Model\UserEntity;
/**
* 
*/
class UserDataAccess
{
	public static function getUserInfoById($uid)
	{
		$UserEntity=new UserEntity();
		$User=$UserEntity->whereEq("id",$uid)->find();
		return $User;
	}

	public static function getSortUserInfo($id){
		$UserEntity=new UserEntity();
		$User=$UserEntity->whereEq("id",$id)->find();
		return [
			"id"=>$id,
			"nickname"=>$User['username']
		];
	}
}