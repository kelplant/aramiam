<?php
namespace SalesforceApiBundle\Services\Manager;

use SalesforceApiBundle\Entity\SalesforceGroupe;
use CoreBundle\Services\Manager\AbstractManager;

/**
 * Class SalesforceGroupeManager
 * @package SalesforceApiBundle\Services\Manager
 */
class SalesforceGroupeManager extends AbstractManager
{
    /**
     * @param $itemToSet
     * @param $itemLoad
     * @return SalesforceGroupe
     */
    public function globalSetItem($itemToSet, $itemLoad)
    {
        $itemToSet->setGroupeId($itemLoad['groupeId']);
        $itemToSet->setGroupeName($itemLoad['groupeName']);
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
        $itemArray['groupeId'] = $itemToTransform->getGroupeId();
        $itemArray['groupeName'] = $itemToTransform->getGroupeName();

        return $itemArray;
    }
}