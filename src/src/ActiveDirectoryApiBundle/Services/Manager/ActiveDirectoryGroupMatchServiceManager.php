<?php
namespace ActiveDirectoryApiBundle\Services\Manager;

use AppBundle\Services\Manager\AbstractManager;
use Doctrine\Common\Util\Inflector;

/**
 * Class ActiveDirectoryGroupMatchServiceManager
 * @package ActiveDirectoryApiBundle\Services\Manager
 */
class ActiveDirectoryGroupMatchServiceManager extends AbstractManager
{
    /**
     * @param $serviceId
     */
    public function purge($serviceId)
    {
        $itemToTransform = $this->getRepository()->findBy(array('serviceId' => $serviceId));

        foreach ($itemToTransform as $item) {
            $this->remove($item->getId());
        }
    }

    /**
     * @param $itemLoad
     * @return mixed
     */
    public function createArray($itemLoad)
    {
        $itemToTransform = $this->getRepository()->findBy(array('serviceId' => $itemLoad));

        $itemArray = [];

        foreach ($itemToTransform as $item) {
            $itemArray[] = $item->getActiveDirectoryGroupId();
        }
        return $itemArray;
    }
}