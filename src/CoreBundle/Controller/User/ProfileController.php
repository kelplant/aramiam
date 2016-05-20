<?php
namespace CoreBundle\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class ProfileController
 * @package CoreBundle\Controller\User
 */
class ProfileController extends Controller
{
    /**
     * @Route(path="/user/profile/show", name="user_profile_show")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showProfileAction()
    {
        $session_messaging = $this->get('session')->get('messaging');
        $this->get('session')->set('messaging', []);
        $globalAlertColor = $this->get('core.index.controller_service')->getGlobalAlertColor($session_messaging);
        $candidatListe = $this->get('core.candidat_manager')->getRepository()->findBy(array('isArchived' => '0'), array('startDate' => 'ASC'));

        $userInfos = $this->get('security.token_storage')->getToken()->getUser();
        $myProfil = $this->get('core.utilisateur_manager')->load($this->get('ad.active_directory_user_link_manager')->getRepository()->findOneByIdentifiant($userInfos->getUsername())->getUser());
        $formEdit = $this->createForm('CoreBundle\Form\Admin\UtilisateurType', $myProfil, array('allow_extra_fields' => $this->get('core.index.controller_service')->generateListeChoices()));

        return $this->render('CoreBundle:User:ProfileShow.html.twig', array(
            'entity'                        => '',
            'nb_candidat'                   => count($candidatListe),
            'candidat_color'                => $this->get('core.index.controller_service')->colorForCandidatSlider($candidatListe[0]->getStartDate()->format("Y-m-d")),
            'session_messaging'             => $session_messaging,
            'formEdit'                      => $formEdit->createView(),
            'currentUserInfos'              => $userInfos,
            'userPhoto'                     => $this->get('google.google_user_api_service')->base64safeToBase64(stream_get_contents($userInfos->getPhoto())),
            'globalAlertColor'              => $globalAlertColor,
            'myProfil'                      => $myProfil,
            'remaining_gmail_licenses'      => $this->get('app.parameters_calls')->getParam('remaining_google_licenses'),
            'remaining_salesforce_licenses' => $this->get('app.parameters_calls')->getParam('remaining_licences_type_Salesforce'),
        ));
    }
}