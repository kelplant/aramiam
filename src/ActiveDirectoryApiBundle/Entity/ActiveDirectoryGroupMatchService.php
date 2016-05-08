<?php
namespace ActiveDirectoryApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * @ORM\Table(name="active_directory_groupe_match_service")
 * @ORM\Entity(repositoryClass="ActiveDirectoryApiBundle\Repository\ActiveDirectoryGroupMatchServiceRepository")
 */
class ActiveDirectoryGroupMatchService
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
     * @ORM\Column(type="string")
     */
    protected $serviceId;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $activeDirectoryGroupId;

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
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return ActiveDirectoryGroupMatchService
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getServiceId()
    {
        return $this->serviceId;
    }

    /**
     * @param string $serviceId
     * @return ActiveDirectoryGroupMatchService
     */
    public function setServiceId($serviceId)
    {
        $this->serviceId = $serviceId;
        return $this;
    }

    /**
     * @return string
     */
    public function getActiveDirectoryGroupId()
    {
        return $this->activeDirectoryGroupId;
    }

    /**
     * @param string $activeDirectoryGroupId
     * @return ActiveDirectoryGroupMatchService
     */
    public function setActiveDirectoryGroupId($activeDirectoryGroupId)
    {
        $this->activeDirectoryGroupId = $activeDirectoryGroupId;
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
     * @return ActiveDirectoryGroupMatchService
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
     * @return ActiveDirectoryGroupMatchService
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}