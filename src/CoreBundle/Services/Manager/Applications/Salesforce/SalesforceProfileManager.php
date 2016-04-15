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
}