<?php
namespace SalesforceApiBundle\Controller;

use SalesforceApiBundle\Entity\SalesforceProfile;
use SalesforceApiBundle\Form\SalesforceProfileType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class SalesforceProfileController
 * @package SalesforceApiBundle\Controller
 */
class SalesforceProfileController extends Controller
{
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
     * @param $salesforceProfileEdit
     * @Route(path="/ajax/salesforce_profile/get/{salesforceProfileEdit}",name="ajax_get_salesforce_profile")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function salesforceProfilesGetInfosIndex($salesforceProfileEdit)
    {
        return new JsonResponse($this->get('salesforce.salesforceprofile_manager')->createArray($salesforceProfileEdit));
    }
}