<?php 

namespace App\Tool;
/**
 * @Author: ‘chenyingqiao’
 * @Date:   2017-04-15 15:23:40
 * @Last Modified by:   ‘chenyingqiao’
 * @Last Modified time: 2017-05-01 15:21:10
 */

/**
* 
*/
class Tool
{
	private static $Tool;
	private function __construct(){}
	public static function getInstanct(){
		if(empty(self::$Tool))
			self::$Tool=new Tool();
		return self::$Tool;
	}

	public function Page($Entity,$pageCurrent=1,$pageSize=6){
		$count=$Entity->count();
		$xdebug_sql=$Entity->sql();
		$pageTotle=ceil($count/$pageSize);
		$limitStart=($pageCurrent-1)*$pageSize;
		if($limitStart>$count){
			$limitStart=$count;
		}
		if($pageCurrent==1){
			$limitStart=0;
		}
		$limitEnd=$limitStart+$pageSize;
		return $Entity->limit($limitStart,$limitEnd);
	}

	public function date_format_iso8601($value){
		$date = new \DateTime(date("Y-m-d h:i:s",$value));
		return $date->format(\DateTime::ATOM); // Updated ISO8601
	}

	public function getUploadFilePrex($filename){
		$arr=explode('.',$filename);
		return $arr[count($arr)-1];
	}
}