<?php
namespace SalesforceApiBundle\Services\Manager;

use SalesforceApiBundle\Entity\SalesforceGroupeMatchFonction;
use AppBundle\Services\Manager\AbstractManager;

/**
 * Class SalesforceGroupeMatchFonctionManager
 * @package SalesforceApiBundle\Services\Manager
 */
class SalesforceGroupeMatchFonctionManager extends AbstractManager
{
    /**
     * @param $fonctionId
     */
    public function purge($fonctionId)
    {
        $itemToTransform = $this->getRepository()->findBy(array('fonctionId' => $fonctionId));

        foreach ($itemToTransform as $item) {
            $this->remove($item->getId());
        }
    }

    /**
     * @param $itemLoad
     * @return mixed
     */
    public function createArray($itemLoad)
    {
        $itemToTransform = $this->getRepository()->findBy(array('fonctionId' => $itemLoad));

        $itemArray = [];

        foreach ($itemToTransform as $item) {
            $itemArray[] = $item->getSalesforceGroupe();
        }
        return $itemArray;
    }
}