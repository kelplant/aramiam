<?php
namespace DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class DashboardBatchController
 * @package DashboardBundle\Controller
 */
class DashboardBatchController extends Controller
{
    /**
     * @Route(path="/ajax/dashboard/licences/global/update/remaining",name="ajax_update_dashboard_licences_gglobal_remaining")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateMaxLicenceNumber()
    {
        $salesforceLicenses = json_decode($this->get('salesforce.salesforce_api_user_service')->getLiencesInformations($this->getParameter('salesforce')))->records;
        foreach ($salesforceLicenses as $licenceType) {
            $this->get('app.parameters_calls')->setParamForName('remaining_licences_type_'.$licenceType->Name, $licenceType->uletas_gamma__Remaining_Licenses__c, 'salesforce_dashboard');
        }
        $actualNumberGmailUserLicenses = $this->get('google.google_user_api_service')->numberGmailUsers(null, $this->getParameter('google_api')) + 2;
        $maxNumberGmailUserLicenses    = $this->get('app.parameters_calls')->getParam('max_google_licenses');
        $remainingGmailLicenses        = $maxNumberGmailUserLicenses - $actualNumberGmailUserLicenses;
        $this->get('app.parameters_calls')->setParamForName('remaining_google_licenses', $remainingGmailLicenses, 'google_dashboard');

        return new JsonResponse(null);
    }

    /**
     * @Route(path="/batch/dashboard/calcul/licenses/{login}/{password}",name="batch_dashboard_calcul_licenses")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function reloadActiveDirectoryGroupeTable($login, $password)
    {
        if ($this->get('app.security.acces_service')->validateUser($login, $password) === true)
        {
            $this->updateMaxLicenceNumber();

            return $this->render("DashboardBundle:Batch:succes.html.twig");
        } else {
            return $this->render("DashboardBundle:Batch:failed.html.twig");
        }
    }
}