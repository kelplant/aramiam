<?php
namespace SalesforceApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return SalesforceProfile
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
     * @return SalesforceProfile
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
     * @return SalesforceProfile
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
     * @return SalesforceProfile
     */
    public function setParentTerritoryId($parentTerritoryId)
    {
        $this->parentTerritoryId = $parentTerritoryId;
        return $this;
    }
}