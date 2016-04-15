<?php
namespace CoreBundle\Services\Manager\Applications\Odigo;

use CoreBundle\Entity\Applications\Odigo\OrangeTelListe;
use CoreBundle\Services\Manager\AbstractManager;

/**
 * Class OrangeTelListeManager
 * @package CoreBundle\Services\Manager\Applications\Odigo
 */
class OrangeTelListeManager extends AbstractManager
{
    /**
     * @param $itemToSet
     * @param $itemLoad
     * @return OrangeTelListe
     */
    public function globalSetItem($itemToSet, $itemLoad)
    {
        $itemToSet->setNumero($itemLoad['numero']);
        $itemToSet->setService($itemLoad['service']);
        $itemToSet->setInUse($itemLoad['inUse']);
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
        $itemArray['numero'] = $itemToTransform->getNumero();
        $itemArray['service'] = $itemToTransform->getService();
        $itemArray['inUse'] = $itemToTransform->getInUse();

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
}