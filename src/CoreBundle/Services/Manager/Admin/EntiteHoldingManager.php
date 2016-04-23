<?php
namespace CoreBundle\Services\Manager\Admin;

use AppBundle\Services\Manager\AbstractManager;
use CoreBundle\Entity\Admin\EntiteHolding;

/**
 * Class EntiteHoldingManager
 * @package CoreBundle\Services\Manager
 */
class EntiteHoldingManager extends AbstractManager
{
    /**
     * @param $itemToSet
     * @param $itemLoad
     * @return EntiteHolding
     */
    public function globalSetItem($itemToSet, $itemLoad)
    {
        $itemToSet->setName($itemLoad['name']);
        $itemToSet->setShortName($itemLoad['shortName']);
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
        $itemArray['id'] = $itemToTransform->getId();
        $itemArray['name'] = $itemToTransform->getName();
        $itemArray['shortName'] = $itemToTransform->getShortName();

        return $itemArray;
    }
}