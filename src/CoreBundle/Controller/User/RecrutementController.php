<?php
namespace CoreBundle\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class RecrutementController
 * @package CoreBundle\Controller\User
 */
class RecrutementController extends Controller
{
    /**
     * @param $isTransformed
     * @Route(path="/user/recrutement/show/{isTransformed}", name="user_recrutement_show")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($isTransformed)
    {
        $session_messaging = $this->get('session')->get('messaging');
        $this->get('session')->set('messaging', []);
        $globalAlertColor = $this->get('core.index.controller_service')->getGlobalAlertColor($session_messaging);

        $candidatListe = $this->get('core.candidat_manager')->getRepository()->findBy(array('isArchived' => '0'), array('startDate' => 'ASC'));

        $userInfos = $this->get('security.token_storage')->getToken()->getUser();
        $myProfil = $this->get('core.utilisateur_manager')->load($this->get('ad.active_directory_user_link_manager')->getRepository()->findOneByIdentifiant($userInfos->getUsername())->getUser());

        $allItems = $this->get('core.candidat_manager')->getRepository()->findBy(array('isArchived' => $isTransformed, 'responsable' => $myProfil->getId()), array('startDate' => 'DESC'));
        foreach ($allItems as $item) {
            $this->get('core.index.controller_service')->ifFilterConvertService($item, 'Candidat');
            $this->get('core.index.controller_service')->ifFilterConvertFonction($item, 'Candidat');
            $this->get('core.index.controller_service')->ifFilterConvertAgence($item, 'Candidat');
        }

        return $this->render('@Core/User/Recrutement/view.html.twig', array(
            'panel'                         => 'user',
            'all'                           => $allItems,
            'is_archived'                   => 0,
            'entity'                        => strtolower($this->get('core.index.controller_service')->checkFormEntity('Candidat')),
            'nb_candidat'                   => count($candidatListe),
            'candidat_color'                => $this->get('core.index.controller_service')->colorForCandidatSlider($candidatListe[0]->getStartDate()->format("Y-m-d")),
            'session_messaging'             => $session_messaging,
            'currentUserInfos'              => $this->get('security.token_storage')->getToken()->getUser(),
            'userPhoto'                     => $this->get('google.google_user_api_service')->base64safeToBase64(stream_get_contents($this->get('security.token_storage')->getToken()->getUser()->getPhoto())),
            'globalAlertColor'              => $globalAlertColor,
            'remaining_gmail_licenses'      => $this->get('app.parameters_calls')->getParam('remaining_google_licenses'),
            'remaining_salesforce_licenses' => $this->get('app.parameters_calls')->getParam('remaining_licences_type_Salesforce'),
        ));
    }
}