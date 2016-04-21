<?php
namespace OdigoApiBundle\Services\Manager;

use OdigoApiBundle\Entity\ProsodieOdigo;
use CoreBundle\Services\Manager\AbstractManager;

/**
 * Class ProsodieOdigoManager
 * @package OdigoApiBundle\Services\Manager
 */
class ProsodieOdigoManager extends AbstractManager
{
    /**
     * @param $itemToSet
     * @param $itemLoad
     * @return ProsodieOdigo
     */
    public function globalSetItem($itemToSet, $itemLoad)
    {
        $itemToSet->setUser($itemLoad['user']);
        $itemToSet->setOdigoPhoneNumber($itemLoad['odigoPhoneNumber']);
        $itemToSet->setRedirectPhoneNumber($itemLoad['redirectPhoneNumber']);
        $itemToSet->setOdigoExtension($itemLoad['odigoExtension']);
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
        $itemArray['user'] = $itemToTransform->getUser();
        $itemArray['odigoPhoneNumber'] = $itemToTransform->getOdigoPhoneNumber();
        $itemArray['redirectPhoneNumber'] = $itemToTransform->getRedirectPhoneNumber();
        $itemArray['odigoExtension'] = $itemToTransform->getOdigoExtension();

        return $itemArray;
    }
}