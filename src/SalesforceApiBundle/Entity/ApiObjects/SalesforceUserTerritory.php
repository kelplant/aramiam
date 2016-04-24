<?php
namespace SalesforceApiBundle\Entity\ApiObjects;

/**
 * Class SalesforceUserTerritory
 * @package SalesforceApiBundle\Entity\ApiObjects
 */
class SalesforceUserTerritory
{
    /**
     *
     * @var string
     */
    public $TerritoryId;

    /**
     * @var string
     */
    public $UserId;

    /**
     * @var string
     */
    public $IsActive;

    /**
     * @return string
     */
    public function getTerritoryId()
    {
        return $this->TerritoryId;
    }

    /**
     * @param string $TerritoryId
     * @return SalesforceUserTerritory
     */
    public function setTerritoryId($TerritoryId)
    {
        $this->TerritoryId = $TerritoryId;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserId()
    {
        return $this->UserId;
    }

    /**
     * @param string $UserId
     * @return SalesforceUserTerritory
     */
    public function setUserId($UserId)
    {
        $this->UserId = $UserId;
        return $this;
    }

    /**
     * @return string
     */
    public function getIsActive()
    {
        return $this->IsActive;
    }

    /**
     * @param string $IsActive
     * @return SalesforceUserTerritory
     */
    public function setIsActive($IsActive)
    {
        $this->IsActive = $IsActive;
        return $this;
    }
}