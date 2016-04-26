<?php
namespace SalesforceApiBundle\Services\Manager;

use SalesforceApiBundle\Entity\SalesforceTerritoryMatchService;
use AppBundle\Services\Manager\AbstractManager;

/**
 * Class SalesforceTerritoryMatchServiceManager
 * @package SalesforceApiBundle\Services\Manager
 */
class SalesforceTerritoryMatchServiceManager extends AbstractManager
{
    public function purge($serviceId)
    {
        $itemToTransform = $this->getRepository()->findBy(array('serviceId' => $serviceId));
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
        $itemToTransform = $this->getRepository()->findBy(array('serviceId' => $itemLoad));
        $itemArray = [];
        foreach ($itemToTransform as $item) {
            $itemArray[] = $item->getSalesforceTerritoryId();
        }
        return $itemArray;
    }


    /**
     * @param $serviceId
     */
    public function deleteForServiceId($serviceId)
    {
        try {
            $this->em->createQuery(
                'DELETE
    FROM SalesforceApiBundle:SalesforceTerritoryMatchService p
    WHERE p.serviceId = :serviceId')->setParameter('serviceId', $serviceId);
        } catch (\Exception $e) {
            $this->appendSessionMessaging(array('errorCode' => error_log($e->getMessage()), 'message' => $e->getMessage()));
        }
    }
}