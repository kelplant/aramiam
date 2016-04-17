<?php
namespace CoreBundle\Services\Manager\Applications\Salesforce;

use CoreBundle\Entity\Applications\Salesforce\SalesforceProfile;
use CoreBundle\Services\Manager\AbstractManager;

/**
 * Class ProfileManager
 * @package CoreBundle\Services\Manager\Applications\Salesforce
 */
class SalesforceProfileManager extends AbstractManager
{
    /**
     * @param $itemToSet
     * @param $itemLoad
     * @return SalesforceProfile
     */
    public function globalSetItem($itemToSet, $itemLoad)
    {
        $itemToSet->setProfileId($itemLoad['profileId']);
        $itemToSet->setProfileName($itemLoad['profileName']);
        $itemToSet->setUserLicenseId($itemLoad['userLicenseId']);
        $itemToSet->setUserType($itemLoad['userType']);
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
        $itemArray['profileId'] = $itemToTransform->getProfileId();
        $itemArray['profileName'] = $itemToTransform->getProfileName();
        $itemArray['userLicenseId'] = $itemToTransform->getUserLicenseId();
        $itemArray['userType'] = $itemToTransform->getUserType();

        return $itemArray;
    }

    /**
     * @return array
     */
    public function getStandardProfileListe()
    {
        return $this->getRepository()->findBy(array('userType' => 'Standard'), array('profileName' => 'ASC'));
    }

    /**
     * @return mixed
     */
    public function truncateTable()
    {
        $connection = $this->managerRegistry->getConnection();
        $platform  = $connection->getDatabasePlatform();

        try {
            return $connection->executeUpdate($platform->getTruncateTableSQL('core_app_salesforce_profile', true));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}