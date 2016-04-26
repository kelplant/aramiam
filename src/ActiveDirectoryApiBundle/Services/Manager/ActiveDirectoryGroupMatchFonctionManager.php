<?php
namespace ActiveDirectoryApiBundle\Services\Manager;

use AppBundle\Services\Manager\AbstractManager;
use Doctrine\Common\Util\Inflector;

/**
 * Class ActiveDirectoryGroupMatchFonctionManager
 * @package ActiveDirectoryApiBundle\Services\Manager
 */
class ActiveDirectoryGroupMatchFonctionManager extends AbstractManager
{
        /**
     * @param $fonctionId
     */
    public function purge($fonctionId)
    {
        $itemToTransform = $this->getRepository()->findBy(array('fonctionId' => $fonctionId));
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
        $itemToTransform = $this->getRepository()->findBy(array('fonctionId' => $itemLoad));
        $itemArray = [];
        foreach ($itemToTransform as $item) {
            $itemArray[] = $item->getActiveDirectoryGroupId();
        }
        return $itemArray;
    }
}