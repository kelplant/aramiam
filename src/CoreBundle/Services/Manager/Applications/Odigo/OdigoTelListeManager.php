<?php
namespace CoreBundle\Services\Manager\Applications\Odigo;

use CoreBundle\Entity\Applications\Odigo\OdigoTelListe;
use CoreBundle\Services\Manager\AbstractManager;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Class OdigoTelListeManager
 * @package CoreBundle\Services\Manager\Applications\Odigo
 */
class OdigoTelListeManager extends AbstractManager
{
    /**
     * @param $itemToSet
     * @param $itemLoad
     * @return OdigoTelListe
     */
    public function globalSetItem($itemToSet, $itemLoad)
    {
        $itemToSet->setNumero($itemLoad['numero']);
        $itemToSet->setService($itemLoad['service']);
        $itemToSet->setInUse($itemLoad['inUse']);
        $itemToSet->setFonction($itemLoad['fonction']);
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
}