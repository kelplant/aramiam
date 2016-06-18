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
     * @param $itemLoad
     * @return array
     */
    public function add($itemLoad)
    {
        if (!isset($itemLoad['in_use']) == true) {
            $itemLoad['in_use'] = 0;
        }
        $itemLoad['numero'] = str_replace(' ', '', $itemLoad['numero']);
        var_dump($itemLoad);

        $itemToSet = $itemToSend = new $this->entity;
        try {
            $itemToSet = $this->globalSetItem($itemToSet, $itemLoad);
            $itemToSet->setCreatedAt(new \DateTime());
            $this->save($itemToSet);
            $this->appendSessionMessaging(array('errorCode' => 0, 'message' => $this->argname.' a eté correctionement Créé(e)'));
        } catch (\Exception $e) {
            $this->appendSessionMessaging(array('errorCode' => error_log($e->getMessage()), 'message' => $e->getMessage()));
        }
        return array('item' => $itemToSend);
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

    /**
     * @return mixed
     */
    public function calculNumberOfNumeroByService()
    {
        $query = 'SELECT core_admin_services.service_name, count(odigo_numorange.numero) as nbnum FROM odigo_numorange LEFT JOIN core_admin_services ON odigo_numorange.service = core_admin_services.id GROUP BY core_admin_services.service_name ORDER BY core_admin_services.service_name';
        return $this->executeRowQuery($query);
    }

    /**
     * @return mixed
     */
    public function calculNumberOfNumeroByServiceInUse()
    {
        $query = 'SELECT core_admin_services.service_name, count(odigo_numorange.numero) as nbnum FROM odigo_numorange LEFT JOIN core_admin_services ON odigo_numorange.service = core_admin_services.id WHERE odigo_numorange.in_use=1 GROUP BY core_admin_services.service_name ORDER BY core_admin_services.service_name';
        return $this->executeRowQuery($query);
    }
}