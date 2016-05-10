<?php
namespace ActiveDirectoryApiBundle\Services\Manager;

use ActiveDirectoryApiBundle\Entity\ActiveDirectoryUserLink;
use AppBundle\Services\Manager\AbstractManager;

/**
 * Class ActiveDirectoryUserLinkManager
 * @package ActiveDirectoryApiBundle\Services\Manager
 */
class ActiveDirectoryUserLinkManager extends AbstractManager
{
    /**
     * @param $itemLoad
     * @return mixed
     */
    public function createArray($itemLoad)
    {
        $itemToTransform = $this->getRepository()->findOneByUser($itemLoad);

        $itemArray = [];

        $itemArray['id']   = $itemToTransform->getId();
        $itemArray['user'] = $itemToTransform->getUser();
        $itemArray['dn']   = $itemToTransform->getDn();
        $itemArray['cn']   = $itemToTransform->getCn();
        $itemArray['identifiant']   = $itemToTransform->getIdentifiant();
        $itemArray['createdAt'] = $itemToTransform->getCreatedAt();
        $itemArray['updatedAt'] = $itemToTransform->getUpdatedAt();

        return $itemArray;
    }

}