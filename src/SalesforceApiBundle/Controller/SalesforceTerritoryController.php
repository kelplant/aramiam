<?php
namespace SalesforceApiBundle\Controller;

use SalesforceApiBundle\Entity\SalesforceTerritory;
use SalesforceApiBundle\Form\SalesforceTerritoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class SalesforceProfileController
 * @package SalesforceApiBundle\Controller
 */
class SalesforceTerritoryController extends Controller
{
    private $itemToTemove;

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
     * @param Request $request
     * @Route(path="/app/salesforce/salesforce_territory/delete/{itemDelete}", defaults={"delete" = 0} , name="remove_salesforceterritory")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Request $request)
    {
        $this->initData('delete');
        $this->initData('index');
        $this->itemToTemove = $request->get('itemDelete');
        $this->get('salesforce.salesforceterritory_manager')->remove($this->itemToTemove);
        return $this->get('core.delete.controller_service')->generateDeleteAction();
    }

    /**
     * @param Request $request
     * @Route(path="/app/salesforce/salesforce_territory/add", name="form_exec_add_salesforce_territory")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function form_exec_addAction(Request $request)
    {
        $this->initData('add');
        $this->initData('index');
        return $this->get('core.add.controller_service')->executeRequestAddAction($request);
    }

    /**
     * @param Request $request
     * @Route(path="/app/salesforce/salesforce_territory/edit", name="form_exec_edit_salesforce_territory")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function form_exec_editAction(Request $request)
    {
        $this->initData('edit');
        $this->initData('index');
        return $this->get('core.edit.controller_service')->executeRequestEditAction($request);
    }
}