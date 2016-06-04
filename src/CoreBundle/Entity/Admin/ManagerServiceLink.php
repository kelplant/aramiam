<?php
namespace CoreBundle\Entity\Admin;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="core_admin_services_managers")
 * @ORM\Entity()
 */
class ManagerServiceLink
{
    /** @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /** @var string
     * @ORM\Column(type="integer")
     */
    protected $serviceId;

    /** @var string
     * @ORM\Column(type="integer")
     */
    protected $userId;

    /** @var string
     * @ORM\Column(type="string")
     */
    protected $profilType;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return ManagerServiceLink
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
     * @return ManagerServiceLink
     */
    public function setServiceId($serviceId)
    {
        $this->serviceId = $serviceId;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param string $userId
     * @return ManagerServiceLink
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return string
     */
    public function getProfilType()
    {
        return $this->profilType;
    }

    /**
     * @param string $profilType
     * @return ManagerServiceLink
     */
    public function setProfilType($profilType)
    {
        $this->profilType = $profilType;
        return $this;
    }
}