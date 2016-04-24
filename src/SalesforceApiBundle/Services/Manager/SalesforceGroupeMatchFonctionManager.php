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
     * @param $itemToSet
     * @param $itemLoad
     * @return SalesforceGroupeMatchFonction
     */
    public function globalSetItem($itemToSet, $itemLoad)
    {
        $itemToSet->setFonctionId($itemLoad['fonctionId']);
        $itemToSet->setSalesforceGroupe($itemLoad['salesforceGroupe']);

        return $itemToSet;
    }

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

    /**
     * @param $fonctionId
     */
    public function deleteForFonctionId($fonctionId)
    {
        try {
            $this->em->createQuery(
                'DELETE
    FROM SalesforceApiBundle:SalesforceGroupeMatchFonction p
    WHERE p.fonctionId = :fonctionId')->setParameter('fonctionId', $fonctionId);
                    } catch (\Exception $e) {
            $this->appendSessionMessaging(array('errorCode' => error_log($e->getMessage()), 'message' => $e->getMessage()));
        }
    }
}