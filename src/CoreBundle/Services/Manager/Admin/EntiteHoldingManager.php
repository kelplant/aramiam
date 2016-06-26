<?php
namespace CoreBundle\Services\Manager\Admin;

use AppBundle\Services\Manager\AbstractManager;
use CoreBundle\Entity\Admin\EntiteHolding;

/**
 * Class EntiteHoldingManager
 * @package CoreBundle\Services\Manager
 */
class EntiteHoldingManager extends AbstractManager
{
    /**
     * @param $itemLoad
     * @return mixed
     */
    public function createArray($itemLoad)
    {
        $itemToTransform = $this->getRepository()->findOneById($itemLoad);

        $itemArray = [];

        $itemArray['id']        = $itemToTransform->getId();
        $itemArray['name']      = $itemToTransform->getName();
        $itemArray['shortName'] = $itemToTransform->getShortName();

        return $itemArray;
    }

    /**
     * @param $itemId
     * @return array
     */
    public function remove($itemId) {

        $itemToSet = $this->getRepository()->findOneById($itemId);
        try {
            if ($itemToSet->getIsArchived() == '0') {
                $itemToSet->setIsArchived('1');
            } else {
                $itemToSet->setIsArchived('0');
            }
            $this->em->flush();
            $this->appendSessionMessaging(array('errorCode' => 0, 'message' => $this->argname.' a eté correctionement Archivé(e)'));
        } catch (\Exception $e) {
            $this->appendSessionMessaging(array('errorCode' => error_log($e->getMessage()), 'message' => $e->getMessage()));
        }

        return array('item' => $itemId);
    }
}