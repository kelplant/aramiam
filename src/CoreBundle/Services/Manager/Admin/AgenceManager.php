<?php
namespace CoreBundle\Services\Manager\Admin;

use AppBundle\Services\Manager\AbstractManager;
use CoreBundle\Entity\Admin\Agence;

/**
 * Class AgenceManager
 * @package CoreBundle\Services\Manager
 */
class AgenceManager extends AbstractManager
{
    /**
     * @param $itemToSet
     * @param $itemLoad
     * @return Agence
     */
    public function globalSetItem($itemToSet, $itemLoad)
    {
        $itemToSet->setName($itemLoad['name']);
        $itemToSet->setNameInCompany($itemLoad['nameInCompany']);
        $itemToSet->setNameInOdigo($itemLoad['nameInOdigo']);
        $itemToSet->setNameInSalesforce($itemLoad['nameInSalesforce']);
        $itemToSet->setNameInZendesk($itemLoad['nameInZendesk']);
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
        $itemArray['nameInCompany'] = $itemToTransform->getNameInCompany();
        $itemArray['nameInOdigo'] = $itemToTransform->getNameInOdigo();
        $itemArray['nameInSalesforce'] = $itemToTransform->getNameInSalesforce();
        $itemArray['nameInZendesk'] = $itemToTransform->getNameInZendesk();

        return $itemArray;
    }
}