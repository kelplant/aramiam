<?php
namespace CoreBundle\Services\Manager;

use CoreBundle\Entity\Admin\Service;

/**
 * Class ServiceManager
 * @package CoreBundle\Manager
 */
class ServiceManager extends AbstractManager
{
    /**
     * @param $itemToSet
     * @param $itemLoad
     * @return Service
     */
    public function globalSetItem($itemToSet, $itemLoad)
    {
        $itemToSet->setName($itemLoad['name']);
        $itemToSet->setShortName($itemLoad['shortName']);
        $itemToSet->setNameInCompany($itemLoad['nameInCompany']);
        $itemToSet->setNameInOdigo($itemLoad['nameInOdigo']);
        $itemToSet->setNameInSalesforce($itemLoad['nameInSalesforce']);
        $itemToSet->setNameInZendesk($itemLoad['nameInZendesk']);

        return $itemToSet;
    }

    /**
     * @param $itemLoad
     * @return bool|int
     */
    public function add($itemLoad)
    {

        $itemToSet = new $this->entity;
        $itemToSet->setName($itemLoad->getName());
        $itemToSet->setShortName($itemLoad->getShortName());
        $itemToSet->setNameInCompany($itemLoad->getNameInCompany());
        $itemToSet->setNameInOdigo($itemLoad->getNameInOdigo());
        $itemToSet->setNameInSalesforce($itemLoad->getNameInSalesforce());
        $itemToSet->setNameInZendesk($itemLoad->getNameInZendesk());

        try {
            $this->save($itemToSet);
            return 6669;
        } catch (\Exception $e) {
            return error_log($e->getMessage());
        }
    }
}