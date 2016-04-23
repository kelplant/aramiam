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
     * @return string
     */
    public function add($itemLoad, $adminId, $type)
    {
        $itemLoad['adminId'] = $adminId;
        $itemLoad['type'] = $type;
        $itemToSet = new MouvHistory();
        $this->globalSetItem($itemToSet, $itemLoad);
        try {
            $this->save($itemToSet);
            return $itemLoad['id'];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}