<?php
namespace CoreBundle\Services\Manager;

use CoreBundle\Entity\Agence;

/**
 * Class AgenceManager
 * @package CoreBundle\Manager
 */
class AgenceManager extends AbstractManager
{
    /**
     * @param $itemToSet
     * @param $itemLoad
     * @return Agence
     */
    public function globalSetItem($itemToSet, $itemLoad)
    {
        $itemToSet->setName($itemLoad['name']);
        $itemToSet->setNameInCompany($itemLoad['nameInCompany']);
        $itemToSet->setNameInOdigo($itemLoad['nameInOdigo']);
        $itemToSet->setNameInSalesforce($itemLoad['nameInSalesforce']);
        $itemToSet->setNameInZendesk($itemLoad['nameInZendesk']);

        return $itemToSet;
    }
}