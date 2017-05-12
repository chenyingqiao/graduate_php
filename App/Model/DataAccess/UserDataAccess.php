<?php 
/**
 * @Author: ‘chenyingqiao’
 * @Date:   2017-04-16 11:49:10
 * @Last Modified by:   ‘chenyingqiao’
 * @Last Modified time: 2017-05-12 09:25:44
 */

namespace App\Model\DataAccess;

use App\Model\UserEntity;
/**
* 
*/
class UserDataAccess
{
	//获取用户信息通过id
	public static function getUserInfoById($uid)
	{
		$UserEntity=new UserEntity();
		$User=$UserEntity->whereEq("id",$uid)->find();
		if(empty($User)){
			return ['username'=>"未知"];
		}
		return $User;
	}

	//获取简短的用户数据
	public static function getSortUserInfo($id){
		$UserEntity=new UserEntity();
		$User=$UserEntity->whereEq("id",$id)->find();
		if(empty($User)){
			return ['username'=>"未知"];
		}
		return [
			"id"=>$id,
			"nickname"=>$User['username']
		];
	}
}