<?php 
/**
 * @Author: ‘chenyingqiao’
 * @Date:   2017-04-08 16:20:44
 * @Last Modified by:   ‘chenyingqiao’
 * @Last Modified time: 2017-04-08 16:31:58
 */
namespace App\Oauth\Db;

use App\Oauth\Db\Traits\EntityTrait;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use Phero\Database\DbUnit;

/**
* 
*/
class RefreshTokenEntity extends DbUnit implements RefreshTokenEntityInterface
{
	use EntityTrait;
	/**
	 * @Field[name='id']
	 * @var [type]
	 */
	public $id;
	/**
	 * @Field[name='access_token_id']
	 * @var [type]
	 */
	public $access_token_id;
	/**
	 * @Field[name='expiry_time']
	 * @var [type]
	 */
	public $expiry_time;

    public $accessToken,$expiryDateTime;

	    /**
     * {@inheritdoc}
     */
    public function setAccessToken(AccessTokenEntityInterface $accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * {@inheritdoc}
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * Get the token's expiry date time.
     *
     * @return \DateTime
     */
    public function getExpiryDateTime()
    {
        return $this->expiryDateTime;
    }

    /**
     * Set the date time when the token expires.
     *
     * @param \DateTime $dateTime
     */
    public function setExpiryDateTime(\DateTime $dateTime)
    {
        $this->expiryDateTime = $dateTime;
    }
}