<?php
namespace CoreBundle\Services\Manager\Applications\Salesforce;

use CoreBundle\Entity\Applications\Salesforce\SalesforceTokenStore;
use CoreBundle\Services\Manager\AbstractManager;

/**
 * Class SalesforceTokenStoreManager
 * @package CoreBundle\Services\Manager\Applications\Salesforce
 */
class SalesforceTokenStoreManager extends AbstractManager
{
    /**
     * @param $itemToSet
     * @param $itemLoad
     * @return SalesforceTokenStore
     */
    public function globalSetItem($itemToSet, $itemLoad)
    {
        $itemToSet->setUsername($itemLoad['username']);
        $itemToSet->setAccessToken($itemLoad['access_token']);
        $itemToSet->setInstanceUrl($itemLoad['instance_url']);
        $itemToSet->setIssuedAt($itemLoad['issued_at']);
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
        $itemArray['username'] = $itemToTransform->getUsername();
        $itemArray['access_token'] = $itemToTransform->getAccessToken();
        $itemArray['instance_url'] = $itemToTransform->getInstanceUrl();
        $itemArray['issued_at'] = $itemToTransform->getIssuedAt();

        return $itemArray;
    }

    /**
     * @param $itemId
     * @return object
     */
    public function loadByUsername($itemId) {
        return $this->getRepository()
            ->findOneBy(array('username' => $itemId));
    }
}