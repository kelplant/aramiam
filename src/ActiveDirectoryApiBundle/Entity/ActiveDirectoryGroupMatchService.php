<?php
namespace ActiveDirectoryApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
}