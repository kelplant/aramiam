<?php
namespace SalesforceApiBundle\Services\Manager;

use SalesforceApiBundle\Entity\SalesforceServiceCloudAcces;
use CoreBundle\Services\Manager\AbstractManager;

/**
 * Class SalesforceServiceCloudAccesManager
 * @package SalesforceApiBundle\Services\Manager
 */
class SalesforceServiceCloudAccesManager extends AbstractManager
{
    /**
     * @param $itemToSet
     * @param $itemLoad
     * @return SalesforceServiceCloudAcces
     */
    public function globalSetItem($itemToSet, $itemLoad)
    {
        $itemToSet->setId($itemLoad['id']);
        $itemToSet->setStatus($itemLoad['status']);

        return $itemToSet;
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
            return $this->edit($itemToEdit, array('id' => $itemToEdit, 'status' => $value));
        }
    }
}