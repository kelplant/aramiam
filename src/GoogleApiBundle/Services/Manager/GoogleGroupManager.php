<?php
namespace GoogleApiBundle\Services\Manager;

use GoogleApiBundle\Entity\GoogleGroup;
use AppBundle\Services\Manager\AbstractManager;

/**
 * Class GoogleGroupManager
 * @package GoogleApiBundle\Services\Manager
 */
class GoogleGroupManager extends AbstractManager
{
    /**
     * @param $itemLoad
     * @return mixed
     */
    public function createArray($itemLoad)
    {
        $itemToTransform = $this->getRepository()->findOneById($itemLoad);
        $itemArray = [];
        $itemArray['id'] = $itemToTransform->getId();
        $itemArray['name'] = $itemToTransform->getName();
        $itemArray['email'] = $itemToTransform->getEmail();

        return $itemArray;
    }

    /**
     * @return array
     */
    public function getStandardProfileListe()
    {
        return $this->getRepository()->findBy(array(), array('name' => 'ASC'));
    }
}