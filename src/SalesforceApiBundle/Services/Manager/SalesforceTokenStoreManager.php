<?php
namespace SalesforceApiBundle\Services\Manager;

use SalesforceApiBundle\Entity\SalesforceTokenStore;
use AppBundle\Services\Manager\AbstractManager;

/**
 * Class SalesforceTokenStoreManager
 * @package SalesforceApiBundle\Services\Manager
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
     * @param $itemLoad
     * @return bool|int
     */
    public function updateOrAdd($itemLoad)
    {
        if (!is_null($this->getRepository()->findOneBy(array('username' => $itemLoad['username'])))) {
        return $this->editByUsername($itemLoad);
        } else {
            $itemToSet = $itemToSend = new $this->entity;
            try {
                $this->save($this->globalSetItem($itemToSet, $itemLoad));
                return array('errorCode' => 6669, 'item' => $itemToSend);
            } catch (\Exception $e) {
                return array('item' => null);
            }
        }
    }

    /**
     * @param $itemEditLoad
     * @return bool|int
     */
    public function editByUsername($itemEditLoad) {
        try {
            $this->globalSetItem($this->getRepository()->findOneBy(array('username' => $itemEditLoad['username'])), $itemEditLoad);
            $this->em->flush();
            return array('errorCode' => 6667, 'item' => $itemEditLoad);
        } catch (\Exception $e) {
            return array('errorCode' => error_log($e->getMessage()), 'error' => $e->getMessage(), 'item' => null);
        }
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