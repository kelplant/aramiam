<?php
namespace SalesforceApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * @ORM\Table(name="salesforce_territory")
 * @ORM\Entity(repositoryClass="SalesforceApiBundle\Repository\SalesforceTerritoryRepository")
 */
class SalesforceTerritory
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
    protected $territoryId;

    /**
     * @var string
     * @ORM\Column(type="string", length=100, unique=true)
     */
    protected $territoryName;

    /**
     * @var string
     * @ORM\Column(type="string", length=30, unique=false, nullable=true)
     */
    protected $parentTerritoryId;

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
     * @return SalesforceTerritory
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getTerritoryId()
    {
        return $this->territoryId;
    }

    /**
     * @param string $territoryId
     * @return SalesforceTerritory
     */
    public function setTerritoryId($territoryId)
    {
        $this->territoryId = $territoryId;
        return $this;
    }

    /**
     * @return string
     */
    public function getTerritoryName()
    {
        return $this->territoryName;
    }

    /**
     * @param string $territoryName
     * @return SalesforceTerritory
     */
    public function setTerritoryName($territoryName)
    {
        $this->territoryName = $territoryName;
        return $this;
    }

    /**
     * @return string
     */
    public function getParentTerritoryId()
    {
        return $this->parentTerritoryId;
    }

    /**
     * @param string $parentTerritoryId
     * @return SalesforceTerritory
     */
    public function setParentTerritoryId($parentTerritoryId)
    {
        $this->parentTerritoryId = $parentTerritoryId;
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
     * @return SalesforceTerritory
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
     * @return SalesforceTerritory
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}