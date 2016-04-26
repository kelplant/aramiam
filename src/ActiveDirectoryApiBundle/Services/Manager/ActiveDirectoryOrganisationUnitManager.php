<?php
namespace ActiveDirectoryApiBundle\Services\Manager;

use AppBundle\Services\Manager\AbstractManager;

/**
 * Class ActiveDirectoryOrganisationUnitManager
 * @package ActiveDirectoryApiBundle\Services\Manager
 */
class ActiveDirectoryOrganisationUnitManager extends AbstractManager
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
        $itemArray['dn'] = $itemToTransform->getDn();
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