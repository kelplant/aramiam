<?php
namespace SalesforceApiBundle\Controller;

use SalesforceApiBundle\Entity\SalesforceProfile;
use SalesforceApiBundle\Form\SalesforceProfileType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class SalesforceProfileController
 * @package SalesforceApiBundle\Controller
 */
class SalesforceProfileController extends Controller
{
    private $itemToTemove;

    /**
     *
     */
    private function initData($service)
    {
        $this->get('core.'.$service.'.controller_service')->setEntity('SalesforceProfile');
        $this->get('core.'.$service.'.controller_service')->setNewEntity(SalesforceProfile::class);
        $this->get('core.'.$service.'.controller_service')->setFormType(SalesforceProfileType::class);
        $this->get('core.'.$service.'.controller_service')->setAlertText('ce profile Salesforce');
        $this->get('core.'.$service.'.controller_service')->setIsArchived(NULL);
        $this->get('core.'.$service.'.controller_service')->setCreateFormArguments(array());
        $this->get('core.'.$service.'.controller_service')->setServicePrefix('salesforce');
    }

    /**
     * @Route(path="/app/salesforce/profile_liste", name="salesforce_profile_liste")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $this->initData('index');
        return $this->get('core.index.controller_service')->generateIndexAction(NULL);
    }

    /**
     * @param Request $request
     * @Route(path="/app/salesforce/salesforce_profile/delete/{itemDelete}", defaults={"delete" = 0} , name="remove_salesforceprofile")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Request $request)
    {
        $this->initData('delete');
        $this->initData('index');
        $this->itemToTemove = $request->get('itemDelete');
        $this->get('salesforce.salesforceprofile_manager')->remove($this->itemToTemove);
        return $this->get('core.delete.controller_service')->generateDeleteAction();
    }

    /**
     * @param Request $request
     * @Route(path="/app/salesforce/salesforce_profile/add", name="form_exec_add_salesforce_profile")
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
     * @Route(path="/app/salesforce/salesforce_profile/edit", name="form_exec_edit_salesforce_profile")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function form_exec_editAction(Request $request)
    {
        $this->initData('edit');
        $this->initData('index');
        return $this->get('core.edit.controller_service')->executeRequestEditAction($request);
    }
}