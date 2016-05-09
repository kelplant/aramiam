<?php
namespace GoogleApiBundle\Services\Manager;

use AppBundle\Services\Manager\AbstractManager;

/**
 * Class GoogleGroupMatchFonctionAndServiceManager
 * @package GoogleApiBundle\Services\Manager
 */
class GoogleGroupMatchFonctionAndServiceManager extends AbstractManager
{
    /**
     * @param $finalTab
     * @param $arrayToparse
     * @return array
     */
    private function parseAndConcatTable($finalTab, $arrayToparse)
    {
        foreach ($arrayToparse as $item) {
            $finalTab[] = $item;
        }
        return $finalTab;
    }

    /**
     * @param $itemLoad
     * @return mixed
     */
    public function createArray($itemLoad)
    {
        $itemToTransform = $this->getRepository()->findOneById($itemLoad);

        $itemArray = [];

        $itemArray['gmailGroupId'] = $itemToTransform->getGmailGroupId();
        $itemArray['fonctionId']   = $itemToTransform->getFonctionId();
        $itemArray['serviceId']    = $itemToTransform->getServiceId();

        return $itemArray;
    }

    /**
     * @param $gmailGroupId
     */
    public function purge($gmailGroupId)
    {
        $itemToTransform = $this->getRepository()->findBy(array('gmailGroupId' => $gmailGroupId));
        foreach ($itemToTransform as $item) {
            $this->remove($item->getId());
        }
    }

    /**
     *
     */
    public function customSelectGmailGroupMatchServiceAndFonction($service, $fonction, $gmailGroupId)
    {
        $queryResult = $this->em->createQuery(
            'SELECT p
    FROM GoogleApiBundle:GoogleGroupMatchFonctionAndService p
    WHERE p.fonctionId = :fonctionId
    AND  p.serviceId = :serviceId
    AND p.gmailGroupId = :gmailGroupId')
            ->setParameter('fonctionId', $fonction)
            ->setParameter('serviceId', $service)
            ->setParameter('gmailGroupId', $gmailGroupId)
            ->getResult();

        $finalTab = [];

        foreach ($queryResult as $result) {
            $finalTab[] = array('gmailGroupId' => $result->getGmailGroupId(), 'fonctionId' => $result->getFonctionId(), 'serviceId' => $result->getServiceId());
        }
        return $finalTab;
    }

    /**
     * @param $serviceId
     * @param $fonctionId
     * @return array
     */
    public function globalGroupListToAdd($serviceId, $fonctionId)
    {
        $arrayForFonction = $this->getRepository()->findBy(array('serviceId' => '', 'fonctionId' => $fonctionId), array('fonctionId' => 'ASC'));
        $arrayForService = $this->getRepository()->findBy(array('serviceId' => $serviceId, 'fonctionId' => ''), array('serviceId' => 'ASC'));
        $arrayForBoth = $this->getRepository()->findBy(array('serviceId' => $serviceId, 'fonctionId' => $fonctionId), array('fonctionId' => 'ASC'));

        $finalTab = [];
        $finalTab = $this->parseAndConcatTable($finalTab, $arrayForFonction);
        $finalTab = $this->parseAndConcatTable($finalTab, $arrayForService);
        $finalTab = $this->parseAndConcatTable($finalTab, $arrayForBoth);

        $finalTab2 = [];
        foreach ($finalTab as $item ) {
            $finalTab2[] = $item->getGmailGroupId();
        }
        return array_unique($finalTab2);
    }
}