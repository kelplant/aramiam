<?php
namespace OdigoApiBundle\Services\Manager;

use OdigoApiBundle\Entity\OrangeTelListe;
use AppBundle\Services\Manager\AbstractManager;

/**
 * Class OrangeTelListeManager
 * @package OdigoApiBundle\Services\Manager
 */
class OrangeTelListeManager extends AbstractManager
{
    /**
     * @param $itemLoad
     * @return mixed
     */
    public function createArray($itemLoad)
    {
        $itemToTransform = $this->getRepository()->findOneById($itemLoad);

        $itemArray = [];

        $itemArray['numero']  = $itemToTransform->getNumero();
        $itemArray['service'] = $itemToTransform->getService();
        $itemArray['inUse']   = $itemToTransform->getInUse();

        return $itemArray;
    }

    /**
     * @param $service
     * @return mixed
     */
    public function getAllTelForService($service)
    {
        $get = $this->getRepository()->findBy(array('service' => $service, 'inUse' => 0), array('numero' => 'ASC'));

        $listeTel = [];

        for ($i = 0; $i <= count($get) - 1; $i++) {
            $listeTel[$i] = $get[$i]->getNumero();
        }
        return $listeTel;
    }

    /**
     * @param $numTel
     * @return mixed
     */
    public function setNumOrangeInUse($numTel)
    {
        $itemToSet = $this->getRepository()->findOneByNumero($numTel);
        $itemToSet->setInUse('1');
        $this->em->flush();

        return $numTel;
    }

    /**
     * @param $num
     * @param $service
     * @return array
     */
    public function addFromApi($num, $service)
    {
        $itemToSet = new $this->entity;
        try {
            $itemToSet->setNumero($num);
            $itemToSet->setService($service);
            $itemToSet->setInUse('0');
            $this->save($itemToSet);
            return '1';
        } catch (\Exception $e) {
            return '0';
        }
    }

    /**
     * @param $orangeNumber
     * @param $ContentToAddToEditedItem
     * @return array
     */
    public function editByNumero($orangeNumber, $ContentToAddToEditedItem) {
        try {
            $itemToSet = $this->globalSetItem($this->getRepository()->findOneByNumero($orangeNumber), $ContentToAddToEditedItem);
            $itemToSet->setUpdatedAt(new \DateTime());
            $this->em->flush();
            $this->appendSessionMessaging(array('errorCode' => 0, 'message' => $this->argname.' a eté correctionement Mis(e) à jour'));
        } catch (\Exception $e) {
            $this->appendSessionMessaging(array('errorCode' => error_log($e->getMessage()), 'message' => $e->getMessage()));
        }

        return array('item' => $orangeNumber);
    }
}