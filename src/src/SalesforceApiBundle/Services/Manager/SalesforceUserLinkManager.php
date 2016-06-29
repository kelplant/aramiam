<?php
namespace SalesforceApiBundle\Services\Manager;

use SalesforceApiBundle\Entity\SalesforceUserLink;
use AppBundle\Services\Manager\AbstractManager;

/**
 * Class SalesforceUserLinkManager
 * @package SalesforceApiBundle\Services\Manager
 */
class SalesforceUserLinkManager extends AbstractManager
{
    /**
     * @param $itemLoad
     * @return mixed
     */
    public function createArray($itemLoad)
    {
        $itemToTransform = $this->getRepository()->findOneById($itemLoad);

        $itemArray = [];

        $itemArray['username']     = $itemToTransform->getUsername();
        $itemArray['access_token'] = $itemToTransform->getAccessToken();
        $itemArray['instance_url'] = $itemToTransform->getInstanceUrl();
        $itemArray['issued_at']    = $itemToTransform->getIssuedAt();

        return $itemArray;
    }
}