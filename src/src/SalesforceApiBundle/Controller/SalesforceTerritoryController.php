<?php
namespace SalesforceApiBundle\Controller;

use SalesforceApiBundle\Entity\SalesforceTerritory;
use SalesforceApiBundle\Form\SalesforceTerritoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class SalesforceProfileController
 * @package SalesforceApiBundle\Controller
 */
class SalesforceTerritoryController extends Controller
{
    /**
     *
     */
    private function initData($service)
    {
        $this->get('core.'.$service.'.controller_service')->setEntity('SalesforceTerritory');
        $this->get('core.'.$service.'.controller_service')->setNewEntity(SalesforceTerritory::class);
        $this->get('core.'.$service.'.controller_service')->setFormType(SalesforceTerritoryType::class);
        $this->get('core.'.$service.'.controller_service')->setAlertText('ce territoire Salesforce');
        $this->get('core.'.$service.'.controller_service')->setIsArchived(NULL);
        $this->get('core.'.$service.'.controller_service')->setCreateFormArguments(array());
        $this->get('core.'.$service.'.controller_service')->setServicePrefix('salesforce');
    }

    /**
     * @Route(path="/app/salesforce/territory_liste", name="salesforce_territory_liste")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $this->initData('index');
        return $this->get('core.index.controller_service')->generateIndexAction(NULL);
    }

    /**
     * @param $salesforceTerritoryEdit
     * @Route(path="/ajax/salesforce_territory/get/{salesforceTerritoryEdit}",name="ajax_get_salesforce_territory")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function salesforceGroupGetInfosIndex($salesforceTerritoryEdit)
    {
        return new JsonResponse($this->get('salesforce.salesforceterritory_manager')->createArray($salesforceTerritoryEdit));
    }
}