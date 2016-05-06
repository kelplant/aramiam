<?php
namespace SalesforceApiBundle\Services\Manager;

use SalesforceApiBundle\Entity\SalesforceServiceCloudAcces;
use AppBundle\Services\Manager\AbstractManager;

/**
 * Class SalesforceServiceCloudAccesManager
 * @package SalesforceApiBundle\Services\Manager
 */
class SalesforceServiceCloudAccesManager extends AbstractManager
{
    /**
     * @param $itemLoad
     * @return mixed
     */
    public function createArray($itemLoad)
    {
        $itemToTransform = $this->getRepository()->findOneById($itemLoad);

        if ($itemToTransform != null) {

            $itemArray = [];

            $itemArray['id']     = $itemToTransform->getId();
            $itemArray['status'] = $itemToTransform->getStatus();

            return $itemArray;
        } else {
            return null;
        }
    }

    /**
     * @param $itemToEdit
     * @param $value
     * @return bool|int
     */
    public function setFonctionAcces($itemToEdit, $value)
    {
        if ($value == 'on') {
            $value = 1;
        } else {
            $value = 0;
        }

        $itemToSet = $this->getRepository()->find($itemToEdit);

        if ($itemToSet == NULL) {
            return $this->add(array('id' => $itemToEdit, 'status' => $value));
        } else {
            $this->edit($itemToEdit, array('id' => $itemToEdit, 'status' => $value));
            return $this->edit($itemToEdit, array('id' => $itemToEdit, 'status' => $value));
        }
    }
}