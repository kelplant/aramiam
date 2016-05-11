<?php
namespace OdigoApiBundle\Services\Manager;

use OdigoApiBundle\Entity\OdigoTelListe;
use AppBundle\Services\Manager\AbstractManager;

/**
 * Class OdigoTelListeManager
 * @package OdigoApiBundle\Services\Manager
 */
class OdigoTelListeManager extends AbstractManager
{
    /**
     * @param $itemLoad
     * @return mixed
     */
    public function createArray($itemLoad)
    {
        $itemToTransform = $this->getRepository()->findOneById($itemLoad);

        $itemArray = [];

        $itemArray['numero']   = $itemToTransform->getNumero();
        $itemArray['service']  = $itemToTransform->getService();
        $itemArray['inUse']    = $itemToTransform->getInUse();
        $itemArray['fonction'] = $itemToTransform->getFonction();

        return $itemArray;
    }

    /**
     * @param $service
     * @param $fonction
     * @return mixed
     */
    public function getAllTelForServiceAndFonction($service, $fonction)
    {
        $get = $this->getRepository()->findBy(array('service' => $service, 'fonction' => $fonction, 'inUse' => 0), array('numero' => 'ASC'));

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
    public function setNumProsodieInUse($numTel)
    {
        $itemToSet = $this->getRepository()->findOneByNumero($numTel);
        $itemToSet->setInUse('1');
        $this->em->flush();
        return $numTel;
    }

    /**
     * @param $num
     * @param $service
     * @param $fonction
     * @return array
     */
    public function addFromApi($num, $service, $fonction)
    {
        $itemToSet = new $this->entity;
        try {
            $itemToSet->setNumero($num);
            $itemToSet->setService($service);
            $itemToSet->setFonction($fonction);
            $itemToSet->setInUse('0');
            $this->save($itemToSet);
            return '1';
        } catch (\Exception $e) {
            return '0';
        }
    }

    /**
     * @param $odigoNumber
     * @param $ContentToAddToEditedItem
     * @return array
     */
    public function editByNumero($odigoNumber, $ContentToAddToEditedItem) {
        try {
            $itemToSet = $this->globalSetItem($this->getRepository()->findOneByNumero($odigoNumber), $ContentToAddToEditedItem);
            $itemToSet->setUpdatedAt(new \DateTime());
            $this->em->flush();
            $this->appendSessionMessaging(array('errorCode' => 0, 'message' => $this->argname.' a eté correctionement Mis(e) à jour'));
        } catch (\Exception $e) {
            $this->appendSessionMessaging(array('errorCode' => error_log($e->getMessage()), 'message' => $e->getMessage()));
        }

        return array('item' => $odigoNumber);
    }
}