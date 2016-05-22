<?php
namespace LauncherBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class LauncherController
 * @package CoreBundle\Controller\User
 */
class LauncherController extends Controller
{
    /**
     * @Route(path="/user/launcher/salesforce", name="user_launcher_salesforce")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function logIntoSalesforceAction()
    {
        $myProfil = $this->getUtilisateurInfos();
        return $this->render('LauncherBundle:Default:salesforce.html.twig',array('myProfil' => $myProfil, 'url' => $this->getParameter('salesforce')));
    }

    /**
     * @Route(path="/user/launcher/odigo", name="user_launcher_odigo")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function logIntoOdigoAction()
    {
        $myProfil = $this->getUtilisateurInfos();
        $odigoInfos = $this->get('odigo.prosodie_odigo_manager')->getRepository()->findOneBy(array('user' => $myProfil->getId()));
        return $this->render('LauncherBundle:Default:odigo.html.twig', array('myProfil' => $myProfil, 'odigoInfos' => $odigoInfos));
    }

    /**
     * @Route(path="/user/launcher/robusto", name="user_launcher_robusto")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function logIntoRobustoAction()
    {
        return $this->render('LauncherBundle:Default:robusto.html.twig');
    }

    /**
     * @return null|object
     */
    private function getUtilisateurInfos()
    {
        $userInfos = $this->get('security.token_storage')->getToken()->getUser();
        return $this->get('core.utilisateur_manager')->load($this->get('ad.active_directory_user_link_manager')->getRepository()->findOneByIdentifiant($userInfos->getUsername())->getUser());
    }

    /**
     * @Route(path="/user/launcher", name="user_launcher")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showProfileAction()
    {
        $session_messaging = $this->get('session')->get('messaging');
        $this->get('session')->set('messaging', []);
        $globalAlertColor = $this->get('core.index.controller_service')->getGlobalAlertColor($session_messaging);
        $candidatListe = $this->get('core.candidat_manager')->getRepository()->findBy(array('isArchived' => '0'), array('startDate' => 'ASC'));
        $userInfos = $this->get('security.token_storage')->getToken()->getUser();
        $myProfil = $this->getUtilisateurInfos();

        return $this->render('LauncherBundle:Default:launcher.html.twig', array(
            'appsTable'                     => $this->get('core.index.controller_service')->generateAppsTable(),
            'panel'                         => 'user',
            'entity'                        => '',
            'nb_candidat'                   => count($candidatListe),
            'candidat_color'                => $this->get('core.index.controller_service')->colorForCandidatSlider($candidatListe[0]->getStartDate()->format("Y-m-d")),
            'session_messaging'             => $session_messaging,
            'formEdit'                      => $this->createForm('CoreBundle\Form\Admin\UtilisateurType', $myProfil, array('allow_extra_fields' => $this->get('core.index.controller_service')->generateListeChoices()))->createView(),
            'currentUserInfos'              => $userInfos,
            'userPhoto'                     => $this->get('google.google_user_api_service')->base64safeToBase64(stream_get_contents($userInfos->getPhoto())),
            'globalAlertColor'              => $globalAlertColor,
            'myProfil'                      => $myProfil,
            'remaining_gmail_licenses'      => $this->get('app.parameters_calls')->getParam('remaining_google_licenses'),
            'remaining_salesforce_licenses' => $this->get('app.parameters_calls')->getParam('remaining_licences_type_Salesforce'),
        ));
    }
}