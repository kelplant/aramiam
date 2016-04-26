<?php
namespace OdigoApiBundle\Services\Manager;

use OdigoApiBundle\Entity\ProsodieOdigo;
use AppBundle\Services\Manager\AbstractManager;

/**
 * Class ProsodieOdigoManager
 * @package OdigoApiBundle\Services\Manager
 */
class ProsodieOdigoManager extends AbstractManager
{
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