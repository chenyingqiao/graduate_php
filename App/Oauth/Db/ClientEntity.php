<?php 
/**
 * @Author: lerko
 * @Date:   2017-04-06 19:43:29
 * @Last Modified by:   lerko
 * @Last Modified time: 2017-04-06 19:49:41
 */
namespace App\Oauth\Db;

use Phero\Database\DbUnit;
/**
* 
*/
class ClientEntity extends DbUnit implements League\OAuth2\Server\Entities\ClientEntityInterface
{
	/**
	 * @Field[name=id]
	 * @var [type]
	 */
	public $id;
	/**
	 * @Field[name=name]
	 * @var [type]
	 */
	public $name;
	/**
	 * @Field[name=redirect_url]
	 * @var [type]
	 */
	public $redirect_url;
	/**
	 * @Field[name=secret]
	 * @var [type]
	 */
	public $secret;
	/**
	 * @Field[name=is_confidential]
	 * @var [type]
	 */
	public $is_confidential;

	 /**
     * Get the client's name.
     *
     * @return string
     * @codeCoverageIgnore
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns the registered redirect URI (as a string).
     *
     * Alternatively return an indexed array of redirect URIs.
     *
     * @return string|string[]
     */
    public function getRedirectUri()
    {
        return $this->redirect_url;
    }
}