<?php
namespace SalesforceApiBundle\Services\Manager;

use SalesforceApiBundle\Entity\SalesforceGroupe;
use AppBundle\Services\Manager\AbstractManager;

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
        $itemToSet->setId($itemLoad['groupeId']);
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
        $itemArray['id'] = $itemToTransform->getId();
        $itemArray['groupeId'] = $itemToTransform->getGroupeId();
        $itemArray['groupeName'] = $itemToTransform->getGroupeName();

        return $itemArray;
    }

    /**
     * @return array
     */
    public function getStandardProfileListe()
    {
        return $this->getRepository()->findBy(array(), array('groupeName' => 'ASC'));
    }
}