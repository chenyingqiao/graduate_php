<?php 
/**
 * @Author: lerko
 * @Date:   2017-04-06 19:40:22
 * @Last Modified by:   ‘chenyingqiao’
 * @Last Modified time: 2017-04-09 07:49:08
 */
namespace App\Oauth\Db\Traits;

trait EntityTrait{
	 /**
     * @return mixed
     */
    public function getIdentifier()
    {
        return $this->id;
    }

    /**
     * @param mixed $identifier
     */
    public function setIdentifier($identifier)
    {
        $this->id = $identifier;
    }
}