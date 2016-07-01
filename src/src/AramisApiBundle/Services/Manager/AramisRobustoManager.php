<?php
namespace AramisApiBundle\Services\Manager;

use AppBundle\Services\Manager\AbstractManager;

/**
 * Class AramisRobustoManager
 * @package AramisApiBundle\Services\Manager
 */
class AramisRobustoManager extends AbstractManager
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
        $itemArray['robustoProfil']   = $itemToTransform->getRobustoProfil();
        $itemArray['robustoUserName']   = $itemToTransform->getRobustoUserName();
        $itemArray['robustoEndDate'] = $itemToTransform->getRobustoEndDate();
        $itemArray['createdAt'] = $itemToTransform->getCreatedAt();
        $itemArray['updatedAt'] = $itemToTransform->getUpdatedAt();

        return $itemArray;
    }
}