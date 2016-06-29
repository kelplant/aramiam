<?php
namespace SalesforceApiBundle\Controller;

use SalesforceApiBundle\Entity\SalesforceGroupe;
use SalesforceApiBundle\Form\SalesforceGroupeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class SalesforceGroupeController
 * @package SalesforceApiBundle\Controller
 */
class SalesforceGroupeController extends Controller
{
    /**
     *
     */
    private function initData($service)
    {
        $this->get('core.'.$service.'.controller_service')->setEntity('SalesforceGroupe');
        $this->get('core.'.$service.'.controller_service')->setNewEntity(SalesforceGroupe::class);
        $this->get('core.'.$service.'.controller_service')->setFormType(SalesforceGroupeType::class);
        $this->get('core.'.$service.'.controller_service')->setAlertText('ce groupe Salesforce');
        $this->get('core.'.$service.'.controller_service')->setIsArchived(NULL);
        $this->get('core.'.$service.'.controller_service')->setCreateFormArguments(array());
        $this->get('core.'.$service.'.controller_service')->setServicePrefix('salesforce');
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
     * @param $salesforceGroupEdit
     * @Route(path="/ajax/salesforce_groupe/get/{salesforceGroupEdit}",name="ajax_get_salesforce_groupe")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function salesforceGroupGetInfosIndex($salesforceGroupEdit)
    {
        return new JsonResponse($this->get('salesforce.salesforcegroupe_manager')->createArray($salesforceGroupEdit));
    }
}