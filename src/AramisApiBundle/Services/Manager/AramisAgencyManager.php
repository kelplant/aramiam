<?php
namespace AramisApiBundle\Services\Manager;

use AramisApiBundle\Entity\AramisAgency;
use AppBundle\Services\Manager\AbstractManager;

/**
 * Class AramisAgencyManager
 * @package AramisApiBundle\Services\Manager
 */
class AramisAgencyManager extends AbstractManager
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