<?php
namespace AppBundle\Services\Manager;

use AppBundle\Entity\MouvHistory;
use DateTime;

/**
 * Class MouvHistoryManager
 * @package AppBundle\Services\Manager
 */
class MouvHistoryManager Extends AbstractManager
{
    /**
     * @param $itemToSet
     * @param $itemLoad
     * @return mixed
     */
    public function globalSetItem($itemToSet, $itemLoad)
    {
        $itemToSet->setUserId($itemLoad['id']);
        $itemToSet->setEntity($itemLoad['entiteHolding']);
        $itemToSet->setAgence($itemLoad['agence']);
        $itemToSet->setService($itemLoad['service']);
        $itemToSet->setFonction($itemLoad['fonction']);
        $itemToSet->setAdminId($itemLoad['adminId']);
        $itemToSet->setDateModif(new Datetime());
        $itemToSet->setType($itemLoad['type']);
        return $itemToSet;
    }

    /**
     * @param $itemLoad
     * @param $adminId
     * @param $type
     * @return array
     */
    public function add($itemLoad, $adminId, $type)
    {
        $itemLoad['adminId'] = $adminId;
        $itemLoad['type'] = $type;
        $itemToSet = $itemToSend = new MouvHistory();
        $this->globalSetItem($itemToSet, $itemLoad);
        try {
            $this->save($itemToSet);
            $this->appendSessionMessaging(array('errorCode' => 0, 'message' => $this->argname.' a eté correctionement Créé(e)'));
        } catch (\Exception $e) {
            $this->appendSessionMessaging(array('errorCode' => error_log($e->getMessage()), 'message' => $e->getMessage()));
        }
        return array('item' => $itemToSend);
    }
}