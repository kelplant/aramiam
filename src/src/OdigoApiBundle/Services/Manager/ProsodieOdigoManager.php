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

    private function setArray($itemToTransform)
    {
        $itemArray = [];

        $itemArray['user']                = $itemToTransform->getUser();
        $itemArray['odigoPhoneNumber']    = $itemToTransform->getOdigoPhoneNumber();
        $itemArray['redirectPhoneNumber'] = $itemToTransform->getRedirectPhoneNumber();
        $itemArray['odigoExtension']      = $itemToTransform->getOdigoExtension();
        $itemArray['profilBase']          = $itemToTransform->getProfilBase();

        return $itemArray;
    }

    /**
     * @param $itemLoad
     * @return mixed
     */
    public function createArray($itemLoad)
    {
        return $this->setArray($this->getRepository()->findOneById($itemLoad));
    }

    /**
     * @param $user
     * @return array
     */
    public function createArrayByUser($user)
    {
        return $this->setArray($this->getRepository()->findOneByUser($user));
    }
}