<?php 

namespace App\Tool;
/**
 * @Author: ‘chenyingqiao’
 * @Date:   2017-04-15 15:23:40
 * @Last Modified by:   ‘chenyingqiao’
 * @Last Modified time: 2017-04-18 23:09:14
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

	public function Page($Entity,$pageCurrent=1,$pageSize=10){
		$count=$Entity->count();
		$xdebug_sql=$Entity->sql();
		$pageTotle=ceil($count/10);
		$limitStart=$pageCurrent*10;
		if($limitStart>$count){
			$limitStart=$count;
		}
		$limitEnd=$limitStart+10;
		return $Entity->limit($limitStart,$limitEnd);
	}

	public function date_format_iso8601($value){
		$date = new \DateTime(date("Y-m-d h:i:s",$value));
		return $date->format(\DateTime::ATOM); // Updated ISO8601
	}
}