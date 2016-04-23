<?php
namespace SalesforceApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="salesforce_tokenstore")
 * @ORM\Entity(repositoryClass="SalesforceApiBundle\Repository\SalesforceTokenStoreRepository")
 */
class SalesforceTokenStore
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=30, unique=true)
     */
    protected $username;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    protected $access_token;

    /**
     * @var string
     * @ORM\Column(type="string", length=100)
     */
    protected $instance_url;

    /**
     * @var string
     * @ORM\Column(type="integer")
     */
    protected $issued_at;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return SalesforceTokenStore
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return SalesforceTokenStore
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return $this->access_token;
    }

    /**
     * @param string $access_token
     * @return SalesforceTokenStore
     */
    public function setAccessToken($access_token)
    {
        $this->access_token = $access_token;
        return $this;
    }

    /**
     * @return string
     */
    public function getInstanceUrl()
    {
        return $this->instance_url;
    }

    /**
     * @param string $instance_url
     * @return SalesforceTokenStore
     */
    public function setInstanceUrl($instance_url)
    {
        $this->instance_url = $instance_url;
        return $this;
    }

    /**
     * @return string
     */
    public function getIssuedAt()
    {
        return $this->issued_at;
    }

    /**
     * @param string $issued_at
     * @return SalesforceTokenStore
     */
    public function setIssuedAt($issued_at)
    {
        $this->issued_at = $issued_at;
        return $this;
    }
}