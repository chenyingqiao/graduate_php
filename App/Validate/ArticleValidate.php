<?php 

namespace App\Validate;

use Psr\Http\Message\ServerRequestInterface;
/**
 * @Author: ‘chenyingqiao’
 * @Date:   2017-04-15 16:34:44
 * @Last Modified by:   ‘chenyingqiao’
 * @Last Modified time: 2017-04-22 13:36:48
 */

/**
* 
*/
class ArticleValidate
{
	//页面检查
	public function validate_getFrontArticleList(ServerRequestInterface &$request){
		$queryData=$request->getQueryParams();

		if(!empty($queryData['currentPage'])){
			if(!is_integer($queryData['currentPage'])){
				return [true];
			}else{
				return [false,"页面标号不是数字"];
			}
		}else{
			$request->withAttribute("currentPage",1);
			return [true];
		}

		if(!empty($queryData['itemsPerPage'])){
			if(!is_integer($queryData['itemsPerPage'])){
				return [true];
			}else{
				return [false,"页面大小不是数字"];
			}
		}else{
			$request->withAttribute("itemsPerPage",10);
			return [true];
		}
	}

}