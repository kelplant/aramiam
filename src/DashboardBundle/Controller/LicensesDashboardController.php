<?php
namespace DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class LicensesDashboardController extends Controller
{
    /**
     * @Route("/admin/licences", name="licences_dashboard")
     */
    public function licensesAction()
    {
        $session_messaging = $this->get('session')->get('messaging');
        $this->get('session')->set('messaging', []);
        $globalAlertColor = $this->get('core.index.controller_service')->getGlobalAlertColor($session_messaging);
        $candidatListe  = $this->get('core.candidat_manager')->getRepository()->findBy(array('isArchived' => '0'), array('startDate' => 'ASC'));

        return $this->render('DashboardBundle:Default:licenses.html.twig', array(
            'entity'                        => '', 'nb_candidat' => count($candidatListe), 'session_messaging' => $session_messaging, 'globalAlertColor' => $globalAlertColor,
            'candidat_color'                => $this->get('core.index.controller_service')->colorForCandidatSlider($candidatListe[0]->getStartDate()->format("Y-m-d")),
            'currentUserInfos'              => $this->get('security.token_storage')->getToken()->getUser(),
            'userPhoto'                     => $this->get('google.google_user_api_service')->base64safeToBase64(stream_get_contents($this->get('security.token_storage')->getToken()->getUser()->getPhoto())),
            'salesforceLicenses'            => json_decode($this->get('salesforce.salesforce_api_user_service')->getLiencesInformations($this->getParameter('salesforce')))->records,
            'actualNumberGmailUserLicenses' => $this->get('google.google_user_api_service')->numberGmailUsers(null, $this->getParameter('google_api')),
            'maxNumberGmailUserLicenses'    => $this->get('app.parameters_calls')->getParam('max_google_licenses'),
            'remaining_gmail_licenses'      => $this->get('app.parameters_calls')->getParam('remaining_google_licenses'),
            'remaining_salesforce_licenses' => $this->get('app.parameters_calls')->getParam('remaining_licences_type_Salesforce'),
        ));
    }
}
