<?php
namespace AramisApiBundle\Services\Manager;

use AramisApiBundle\Entity\AramisAgency;
use CoreBundle\Services\Manager\AbstractManager;

/**
 * Class AramisAgencyManager
 * @package AramisApiBundle\Services\Manager
 */
class AramisAgencyManager extends AbstractManager
{
    /**
     * @param $itemToSet
     * @param $itemLoad
     * @return AramisAgency
     */
    public function globalSetItem($itemToSet, $itemLoad)
    {
        $itemToSet->setId($itemLoad['id']);
        $itemToSet->setCetelemCode($itemLoad['cetelemCode']);
        $itemToSet->setLizautoCode($itemLoad['lizautoCode']);
        $itemToSet->setLabel($itemLoad['label']);
        $itemToSet->setAddress1($itemLoad['address1']);
        $itemToSet->setZipCode($itemLoad['zipCode']);
        $itemToSet->setCity($itemLoad['city']);
        $itemToSet->setPhone($itemLoad['phone']);
        $itemToSet->setEmail($itemLoad['email']);
        $itemToSet->setPointOfSale($itemLoad['pointOfSale']);
        $itemToSet->setCoordonnees($itemLoad['coordonnees']);
        $itemToSet->setCargarantieId($itemLoad['cargarantieId']);
        $itemToSet->setSlug($itemLoad['slug']);
        $itemToSet->setShortUrl($itemLoad['shortUrl']);
        $itemToSet->setFullUrl($itemLoad['fullUrl']);
        $itemToSet->setDetailPageTitle($itemLoad['detailPageTitle']);
        $itemToSet->setIsSaleAppointmentsEligible($itemLoad['isSaleAppointmentsEligible']);
        $itemToSet->setIsPurchaseAppointmentsEligible($itemLoad['isPurchaseAppointmentsEligible']);
        $itemToSet->setIsPurchaseSaleAppointmentsEligible($itemLoad['isPurchaseSaleAppointmentsEligible']);

        return $itemToSet;
    }

    /**
     * @param $itemLoad
     * @return mixed
     */
    public function createArray($itemLoad)
    {
        $itemToTransform = $this->getRepository()->findOneById($itemLoad);
        $itemArray = [];
        $itemArray['id'] = $itemToTransform->getId();
        $itemArray['cetelemCode'] = $itemToTransform->getCetelemCode();
        $itemArray['lizautoCode'] = $itemToTransform->getLizautoCode();
        $itemArray['label'] = $itemToTransform->getLabel();
        $itemArray['address1'] = $itemToTransform->getAddress1();
        $itemArray['zipCode'] = $itemToTransform->getZipCode();
        $itemArray['city'] = $itemToTransform->getCity();
        $itemArray['phone'] = $itemToTransform->getPhone();
        $itemArray['email'] = $itemToTransform->getEmail();
        $itemArray['pointOfSale'] = $itemToTransform->getPointOfSale();
        $itemArray['coordonnees'] = $itemToTransform->getCoordonnees();
        $itemArray['cargarantieId'] = $itemToTransform->getCargarantieId();
        $itemArray['slug'] = $itemToTransform->getSlug();
        $itemArray['shortUrl'] = $itemToTransform->getShortUrl();
        $itemArray['fullUrl'] = $itemToTransform->getFullUrl();
        $itemArray['detailPageTitle'] = $itemToTransform->getDetailPageTitle();
        $itemArray['isSaleAppointmentsEligible'] = $itemToTransform->getIsSaleAppointmentsEligible();
        $itemArray['isPurchaseAppointmentsEligible'] = $itemToTransform->getIsPurchaseAppointmentsEligible();
        $itemArray['isPurchaseSaleAppointmentsEligible'] = $itemToTransform->getIsPurchaseSaleAppointmentsEligible();

        return $itemArray;
    }
}