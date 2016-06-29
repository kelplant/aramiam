<?php
namespace DashboardBundle\Services\Manager;

use AppBundle\Services\Manager\AbstractManager;

/**
 * Class DashboardTodoListEventManager
 * @package DashboardBundle\Services\Manager
 */
class DashboardTodoListEventManager extends AbstractManager
{
    /**
     * @param $itemLoad
     * @return mixed
     */
    public function createArray($itemLoad)
    {
        $itemToTransform = $this->getRepository()->findOneById($itemLoad);

        $itemArray = [];

        $itemArray['id']         = $itemToTransform->getId();
        $itemArray['name']       = $itemToTransform->getName();
        $itemArray['comment']    = $itemToTransform->getComment();
        $itemArray['createDate'] = $itemToTransform->getCreateDate();
        $itemArray['isDone']     = $itemToTransform->getIsDone();

        return $itemArray;
    }
}