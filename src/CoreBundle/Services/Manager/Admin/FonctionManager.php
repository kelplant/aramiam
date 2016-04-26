<?php
namespace CoreBundle\Services\Manager\Admin;

use AppBundle\Services\Manager\AbstractManager;
use CoreBundle\Entity\Admin\Fonction;

/**
 * Class FonctionManager
 * @package CoreBundle\Services\Manager
 */
class FonctionManager extends AbstractManager
{
    /**
     * @param $itemLoad
     * @return mixed
     */
    public function createArray($itemLoad) {

        $itemToTransform = $this->getRepository()->findOneById($itemLoad);
        $itemArray = [];
        $itemArray['id'] = $itemToTransform->getId();
        $itemArray['name'] = $itemToTransform->getName();
        $itemArray['shortName'] = $itemToTransform->getShortName();
        $itemArray['nameInCompany'] = $itemToTransform->getNameInCompany();
        $itemArray['nameInOdigo'] = $itemToTransform->getNameInOdigo();
        $itemArray['nameInSalesforce'] = $itemToTransform->getNameInSalesforce();
        $itemArray['nameInZendesk'] = $itemToTransform->getNameInZendesk();

        return $itemArray;
    }
}