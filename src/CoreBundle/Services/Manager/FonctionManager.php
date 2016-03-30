<?php
namespace CoreBundle\Services\Manager;

use CoreBundle\Entity\Admin\Fonction;

/**
 * Class FonctionManager
 * @package CoreBundle\Manager
 */
class FonctionManager extends AbstractManager
{
    /**
     * @param $itemToSet
     * @param $itemLoad
     * @return Fonction
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
}