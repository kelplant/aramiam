<?php
namespace CoreBundle\Services\Manager\Admin;

use AppBundle\Services\Manager\AbstractManager;

/**
 * Class UtilisateurPhotoManager
 * @package CoreBundle\Services\Manager
 */
class UtilisateurPhotoManager extends AbstractManager
{
    /**
     * @param $itemLoad
     * @return mixed
     */
    public function createArray($itemLoad)
    {
        $itemToTransform = $this->getRepository()->findOneById($itemLoad);

        $itemArray = [];

        $itemArray['userId']   = $itemToTransform->getUserId();
        $itemArray['mineType'] = $itemToTransform->getMineType();
        $itemArray['photo']    = $itemToTransform->getPhoto();

        return $itemArray;
    }
}