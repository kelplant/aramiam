<?php
namespace CoreBundle\Services\Manager\Applications\Odigo;

use CoreBundle\Entity\Applications\Odigo\OrangeTelListe;
use CoreBundle\Services\Manager\AbstractManager;
use Doctrine\Common\Persistence\ManagerRegistry;

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
}