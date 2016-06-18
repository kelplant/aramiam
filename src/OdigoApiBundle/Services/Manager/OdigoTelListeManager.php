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
     * @param $itemLoad
     * @return array
     */
    public function add($itemLoad)
    {
        if (!isset($itemLoad['in_use']) == true) {
            $itemLoad['in_use'] = 0;
        }
        $itemLoad['numero'] = str_replace(' ', '', $itemLoad['numero']);
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

    /**
     * @return mixed
     */
    public function calculNumberOfNumeroByServiceForAgencies()
    {
        $query = 'SELECT core_admin_services.service_name, core_admin_fonctions.fonction_name, count(odigo_numodigo.numero) as nbnum FROM odigo_numodigo LEFT JOIN core_admin_services ON odigo_numodigo.service = core_admin_services.id LEFT JOIN core_admin_fonctions ON odigo_numodigo.fonction = core_admin_fonctions.id WHERE core_admin_services.service_name != \'The Custumer Company\' AND core_admin_services.service_name != \'Webhelp\' AND core_admin_services.service_name != \'Satisfaction Client\' GROUP BY odigo_numodigo.service, odigo_numodigo.fonction ORDER BY core_admin_services.service_name';
        return $this->executeRowQuery($query);
    }

    /**
     * @return mixed
     */
    public function calculNumberOfNumeroByServiceInUseForAgencies()
    {
    $query = 'SELECT core_admin_services.service_name, core_admin_fonctions.fonction_name, count(odigo_numodigo.numero) as nbnum FROM odigo_numodigo LEFT JOIN core_admin_services ON odigo_numodigo.service = core_admin_services.id LEFT JOIN core_admin_fonctions ON odigo_numodigo.fonction = core_admin_fonctions.id WHERE odigo_numodigo.in_use=1 AND  core_admin_services.service_name != \'The Custumer Company\' AND core_admin_services.service_name != \'Webhelp\' AND core_admin_services.service_name != \'Satisfaction Client\' GROUP BY odigo_numodigo.service, odigo_numodigo.fonction ORDER BY core_admin_services.service_name';
        return $this->executeRowQuery($query);
    }

    /**
     * @return mixed
     */
    public function calculNumberOfNumeroByServiceForPFA()
    {
        $query = 'SELECT core_admin_services.service_name, core_admin_fonctions.fonction_name, count(odigo_numodigo.numero) as nbnum FROM odigo_numodigo LEFT JOIN core_admin_services ON odigo_numodigo.service = core_admin_services.id LEFT JOIN core_admin_fonctions ON odigo_numodigo.fonction = core_admin_fonctions.id WHERE core_admin_services.service_name = \'The Custumer Company\' OR core_admin_services.service_name = \'Webhelp\' GROUP BY odigo_numodigo.service, odigo_numodigo.fonction ORDER BY core_admin_services.service_name';
        return $this->executeRowQuery($query);
    }

    /**
     * @return mixed
     */
    public function calculNumberOfNumeroByServiceInUseForPFA()
    {
        $query = 'SELECT core_admin_services.service_name, core_admin_fonctions.fonction_name, count(odigo_numodigo.numero) as nbnum FROM odigo_numodigo LEFT JOIN core_admin_services ON odigo_numodigo.service = core_admin_services.id LEFT JOIN core_admin_fonctions ON odigo_numodigo.fonction = core_admin_fonctions.id WHERE odigo_numodigo.in_use=1 AND  core_admin_services.service_name = \'The Custumer Company\' OR core_admin_services.service_name = \'Webhelp\'  GROUP BY odigo_numodigo.service, odigo_numodigo.fonction ORDER BY core_admin_services.service_name';
        return $this->executeRowQuery($query);
    }

    /**
     * @return mixed
     */
    public function calculNumberOfNumeroByServiceForSSC()
    {
        $query = 'SELECT core_admin_services.service_name, core_admin_fonctions.fonction_name, count(odigo_numodigo.numero) as nbnum FROM odigo_numodigo LEFT JOIN core_admin_services ON odigo_numodigo.service = core_admin_services.id LEFT JOIN core_admin_fonctions ON odigo_numodigo.fonction = core_admin_fonctions.id WHERE core_admin_services.service_name = \'Satisfaction Client\'  GROUP BY odigo_numodigo.service, odigo_numodigo.fonction ORDER BY core_admin_services.service_name';
        return $this->executeRowQuery($query);
    }

    /**
     * @return mixed
     */
    public function calculNumberOfNumeroByServiceInUseForSSC()
    {
        $query = 'SELECT core_admin_services.service_name, core_admin_fonctions.fonction_name, count(odigo_numodigo.numero) as nbnum FROM odigo_numodigo LEFT JOIN core_admin_services ON odigo_numodigo.service = core_admin_services.id LEFT JOIN core_admin_fonctions ON odigo_numodigo.fonction = core_admin_fonctions.id WHERE odigo_numodigo.in_use=1 AND  core_admin_services.service_name = \'Satisfaction Client\' GROUP BY odigo_numodigo.service, odigo_numodigo.fonction ORDER BY core_admin_services.service_name';
        return $this->executeRowQuery($query);
    }
}