<?php
namespace CoreBundle\Services\Manager\Applications\Salesforce;

use CoreBundle\Entity\Applications\Salesforce\SalesforceGroupe;
use CoreBundle\Services\Manager\AbstractManager;

/**
 * Class SalesforceGroupeManager
 * @package CoreBundle\Services\Manager\Applications\Salesforce
 */
class SalesforceGroupeManager extends AbstractManager
{
    /**
     * @param $itemToSet
     * @param $itemLoad
     * @return SalesforceGroupe
     */
    public function globalSetItem($itemToSet, $itemLoad)
    {
        $itemToSet->setGroupeId($itemLoad['groupeId']);
        $itemToSet->setGroupeName($itemLoad['groupeName']);
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
        $itemArray['groupeId'] = $itemToTransform->getGroupeId();
        $itemArray['groupeName'] = $itemToTransform->getGroupeName();

        return $itemArray;
    }

    /**
     * @return mixed
     */
    public function truncateTable()
    {
        $connection = $this->managerRegistry->getConnection();
        $platform  = $connection->getDatabasePlatform();

        try {
            return $connection->executeUpdate($platform->getTruncateTableSQL('core_app_salesforce_groupe', true));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}