<?php
namespace ActiveDirectoryApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * Class ActiveDirectoryUserLink
 * @ORM\Entity()
 * @ORM\Table(name="active_directory_link_user")
 */
class ActiveDirectoryUserLink
{
    /** @ORM\Id()
     * @ORM\Column(type="string")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="integer")
     */
    protected $user;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    protected $dn;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    protected $cn;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    protected $identifiant;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $createdAt;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $updatedAt;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return ActiveDirectoryUserLink
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param string $user
     * @return ActiveDirectoryUserLink
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return string
     */
    public function getDn()
    {
        return $this->dn;
    }

    /**
     * @param string $dn
     * @return ActiveDirectoryUserLink
     */
    public function setDn($dn)
    {
        $this->dn = $dn;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     * @return ActiveDirectoryUserLink
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime $updatedAt
     * @return ActiveDirectoryUserLink
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return string
     */
    public function getIdentifiant()
    {
        return $this->identifiant;
    }

    /**
     * @param string $identifiant
     * @return ActiveDirectoryUserLink
     */
    public function setIdentifiant($identifiant)
    {
        $this->identifiant = $identifiant;
        return $this;
    }

    /**
     * @return string
     */
    public function getCn()
    {
        return $this->cn;
    }

    /**
     * @param string $cn
     * @return ActiveDirectoryUserLink
     */
    public function setCn($cn)
    {
        $this->cn = $cn;
        return $this;
    }
}