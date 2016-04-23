<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;
/**
 * Class MouvHistory
 * @ORM\Entity()
 * @ORM\Table(name="app_mouvhistory")
 */
class MouvHistory
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
     * @ORM\Column(type="integer")
     */
    protected $userId;

    /**
     * @var string
     * @ORM\Column(type="string", length=100)
     */
    protected $entity;

    /**
     * @var string
     * @ORM\Column(type="integer")
     */
    protected $agence;

    /**
     * @var string
     * @ORM\Column(type="integer")
     */
    protected $service;

    /**
     * @var string
     * @ORM\Column(type="integer")
     */
    protected $fonction;

    /**
     * @var string
     * @ORM\Column(type="integer")
     */
    protected $adminId;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime")
     */
    protected $dateModif;

    /**
     * @var string
     * @ORM\Column(type="string", length=2)
     */
    protected $type;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return MouvHistory
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * @return MouvHistory
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return string
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param string $entity
     * @return MouvHistory
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
        return $this;
    }

    /**
     * @return string
     */
    public function getAgence()
    {
        return $this->agence;
    }

    /**
     * @param string $agence
     * @return MouvHistory
     */
    public function setAgence($agence)
    {
        $this->agence = $agence;
        return $this;
    }

    /**
     * @return string
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param string $service
     * @return MouvHistory
     */
    public function setService($service)
    {
        $this->service = $service;
        return $this;
    }

    /**
     * @return string
     */
    public function getFonction()
    {
        return $this->fonction;
    }

    /**
     * @param string $fonction
     * @return MouvHistory
     */
    public function setFonction($fonction)
    {
        $this->fonction = $fonction;
        return $this;
    }

    /**
     * @return string
     */
    public function getAdminId()
    {
        return $this->adminId;
    }

    /**
     * @param string $adminId
     * @return MouvHistory
     */
    public function setAdminId($adminId)
    {
        $this->adminId = $adminId;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDateModif()
    {
        return $this->dateModif;
    }

    /**
     * @param DateTime $dateModif
     * @return MouvHistory
     */
    public function setDateModif($dateModif)
    {
        $this->dateModif = $dateModif;
        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return MouvHistory
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }
}