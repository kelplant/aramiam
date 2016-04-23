<?php
namespace SalesforceApiBundle\Services\Manager;

use SalesforceApiBundle\Entity\SalesforceProfile;
use AppBundle\Services\Manager\AbstractManager;

/**
 * Class SalesforceProfileManager
 * @package SalesforceApiBundle\Services\Manager
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
}