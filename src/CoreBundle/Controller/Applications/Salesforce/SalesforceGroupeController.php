<?php
namespace CoreBundle\Controller\Applications\Salesforce;

use CoreBundle\Entity\Applications\Salesforce\SalesforceGroupe;
use CoreBundle\Form\Applications\Salesforce\SalesforceGroupeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class SalesforceGroupeController
 * @package CoreBundle\Controller\Applications\Salesforce
 */
class SalesforceGroupeController extends Controller
{
    private $itemToTemove;

    /**
     *
     */
    private function initData($service)
    {
        $this->get('core.'.$service.'.controller_service')->setMessage('');
        $this->get('core.'.$service.'.controller_service')->setInsert('');
        $this->get('core.'.$service.'.controller_service')->setEntity('SalesforceGroupe');
        $this->get('core.'.$service.'.controller_service')->setNewEntity(SalesforceGroupe::class);
        $this->get('core.'.$service.'.controller_service')->setFormType(SalesforceGroupeType::class);
        $this->get('core.'.$service.'.controller_service')->setAlertText('ce groupe Salesforce');
        $this->get('core.'.$service.'.controller_service')->setIsArchived(NULL);
        $this->get('core.'.$service.'.controller_service')->setCreateFormArguments(array());
    }

    /**
     * @Route(path="/app/salesforce/groupe_liste", name="salesforce_groupe_liste")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $this->initData('index');
        return $this->get('core.index.controller_service')->generateIndexAction(NULL);
    }

    /**
     * @param Request $request
     * @Route(path="/app/salesforce/salesforce_groupe/delete/{itemDelete}", defaults={"delete" = 0} , name="remove_salesforcegroupe")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Request $request)
    {
        $this->initData('delete');
        $this->initData('index');
        $this->itemToTemove = $request->get('itemDelete');
        $this->get('core.delete.controller_service')->setRemove($this->get('core.salesforcegroupe_manager')->remove($this->itemToTemove));
        return $this->get('core.delete.controller_service')->generateDeleteAction();
    }

    /**
     * @param Request $request
     * @Route(path="/app/salesforce/salesforce_groupe/add", name="form_exec_add_salesforce_groupe")
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
     * @Route(path="/app/salesforce/salesforce_groupe/edit", name="form_exec_edit_salesforce_groupe")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function form_exec_editAction(Request $request)
    {
        $this->initData('edit');
        $this->initData('index');
        return $this->get('core.edit.controller_service')->executeRequestEditAction($request);
    }
}