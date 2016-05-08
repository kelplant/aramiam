<?php
namespace SalesforceApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * @ORM\Table(name="salesforce_groupe")
 * @ORM\Entity(repositoryClass="SalesforceApiBundle\Repository\SalesforceGroupeRepository")
 */
class SalesforceGroupe
{
    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(type="string", unique=true)
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=30, unique=true)
     */
    protected $groupeId;

    /**
     * @var string
     * @ORM\Column(type="string", length=100, unique=true)
     */
    protected $groupeName;

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
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return SalesforceGroupe
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getGroupeId()
    {
        return $this->groupeId;
    }

    /**
     * @param string $groupeId
     * @return SalesforceGroupe
     */
    public function setGroupeId($groupeId)
    {
        $this->groupeId = $groupeId;
        return $this;
    }

    /**
     * @return string
     */
    public function getGroupeName()
    {
        return $this->groupeName;
    }

    /**
     * @param string $groupeName
     * @return SalesforceGroupe
     */
    public function setGroupeName($groupeName)
    {
        $this->groupeName = $groupeName;
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
     * @return SalesforceGroupe
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
     * @return SalesforceGroupe
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}