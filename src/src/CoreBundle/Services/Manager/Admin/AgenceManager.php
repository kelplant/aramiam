<?php
namespace CoreBundle\Services\Manager\Admin;

use AppBundle\Services\Manager\AbstractManager;
use CoreBundle\Entity\Admin\Agence;

/**
 * Class AgenceManager
 * @package CoreBundle\Services\Manager
 */
class AgenceManager extends AbstractManager
{
    /**
     * @param $itemLoad
     * @return mixed
     */
    public function createArray($itemLoad)
    {
        $itemToTransform = $this->getRepository()->findOneById($itemLoad);

        $itemArray = [];

        $itemArray['id']                    = $itemToTransform->getId();
        $itemArray['name']                  = $itemToTransform->getName();
        $itemArray['nameInCompany']         = $itemToTransform->getNameInCompany();
        $itemArray['nameInOdigo']           = $itemToTransform->getNameInOdigo();
        $itemArray['nameInSalesforce']      = $itemToTransform->getNameInSalesforce();
        $itemArray['nameInZendesk']         = $itemToTransform->getNameInZendesk();
        $itemArray['nameInActiveDirectory'] = $itemToTransform->getNameInActiveDirectory();

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

    /**
     *
     */
    public function customSelectNameInActiveDirectoryNotNull() {

        $queryResult = $this->em->createQuery(
            'SELECT p.nameInActiveDirectory
    FROM CoreBundle:Admin\Agence p
    WHERE p.nameInActiveDirectory IS NOT NULL')->getResult();
        $finalTab = [];
        foreach ($queryResult as $result) {
            $finalTab[] = $result['nameInActiveDirectory'];
        }
        return $finalTab;
    }
}