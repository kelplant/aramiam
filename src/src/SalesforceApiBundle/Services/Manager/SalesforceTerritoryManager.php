<?php
namespace SalesforceApiBundle\Services\Manager;

use SalesforceApiBundle\Entity\SalesforceTerritory;
use AppBundle\Services\Manager\AbstractManager;

/**
 * Class SalesforceTerritoryManager
 * @package SalesforceApiBundle\Services\Manager
 */
class SalesforceTerritoryManager extends AbstractManager
{
    /**
     * @param $itemToSet
     * @param $itemLoad
     * @return SalesforceTerritory
     */
    public function globalSetItem($itemToSet, $itemLoad)
    {
        $itemToSet->setId($itemLoad['territoryId']);
        $itemToSet->setTerritoryId($itemLoad['territoryId']);
        $itemToSet->setTerritoryName($itemLoad['territoryName']);
        $itemToSet->setParentTerritoryId($itemLoad['parentTerritoryId']);
        return $itemToSet;
    }

    /**
     * @param $itemLoad
     * @return mixed
     */
    public function createArray($itemLoad)
    {
        $itemToTransform = $this->getRepository()->findOneById($itemLoad);

        $itemArray = [];

        $itemArray['id']                = $itemToTransform->getId();
        $itemArray['territoryId']       = $itemToTransform->getTerritoryId();
        $itemArray['territoryName']     = $itemToTransform->getTerritoryName();
        $itemArray['parentTerritoryId'] = $itemToTransform->getParentTerritoryId();

        return $itemArray;
    }

    /**
     * @return array
     */
    public function getStandardTerritoriesListe()
    {
        return $this->getRepository()->findBy(array(), array('territoryName' => 'ASC'));
    }
}