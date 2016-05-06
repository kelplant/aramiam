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
     * @param $itemLoad
     * @return mixed
     */
    public function createArray($itemLoad)
    {
        $itemToTransform = $this->getRepository()->findOneById($itemLoad);

        $itemArray = [];

        $itemArray['id']                    = $itemToTransform->getId();
        $itemArray['name']                  = $itemToTransform->getName();
        $itemArray['nameInCompany']         = $itemToTransform->getNameInCompany();
        $itemArray['nameInOdigo']           = $itemToTransform->getNameInOdigo();
        $itemArray['nameInSalesforce']      = $itemToTransform->getNameInSalesforce();
        $itemArray['nameInZendesk']         = $itemToTransform->getNameInZendesk();
        $itemArray['nameInActiveDirectory'] = $itemToTransform->getNameInActiveDirectory();

        return $itemArray;
    }

    /**
     *
     */
    public function customSelectNameInActiveDirectoryNotNull() {

        $queryResult = $this->em->createQuery(
            'SELECT p.nameInActiveDirectory
    FROM CoreBundle:Admin\Agence p
    WHERE p.nameInActiveDirectory IS NOT NULL')->getResult();
        $finalTab = [];
        foreach ($queryResult as $result) {
            $finalTab[] = $result['nameInActiveDirectory'];
        }
        return $finalTab;
    }
}