<?php
namespace CoreBundle\Controller\User;

use CoreBundle\Entity\Admin\Utilisateur;
use CoreBundle\Form\Admin\UtilisateurType;
use CoreBundle\Form\User\EquipeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class EquipeController
 * @package CoreBundle\Controller\User
 */
class EquipeController extends Controller
{
    /**
     * @param $utilisateurEdit
     * @Route(path="/user/ajax/utilisateur/get/{utilisateurEdit}",name="user_ajax_get_utilisateur")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function utilisateurGetInfosIndex($utilisateurEdit)
    {
        $fullInfos = $this->get('core.utilisateur_manager')->createArray($utilisateurEdit);
        unset($fullInfos['mainPassword']);
        return new JsonResponse($fullInfos);
    }

    /**
     * @param $isArchived
     * @Route(path="/user/equipe/show/{isArchived}", name="user_equipe_show")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($isArchived)
    {
        $session_messaging = $this->get('session')->get('messaging');
        $this->get('session')->set('messaging', []);
        $globalAlertColor = $this->get('core.index.controller_service')->getGlobalAlertColor($session_messaging);

        $candidatListe = $this->get('core.candidat_manager')->getRepository()->findBy(array('isArchived' => '0'), array('startDate' => 'ASC'));

        $userInfos = $this->get('security.token_storage')->getToken()->getUser();
        $myProfil = $this->get('core.utilisateur_manager')->load($this->get('ad.active_directory_user_link_manager')->getRepository()->findOneByIdentifiant($userInfos->getUsername())->getUser());

        $allItems = $this->get('core.utilisateur_manager')->getRepository()->findBy(array('isArchived' => $isArchived, 'responsable' => $myProfil->getId()), array('startDate' => 'DESC'));
        foreach ($allItems as $item) {
            $this->get('core.index.controller_service')->ifFilterConvertService($item, 'Candidat');
            $this->get('core.index.controller_service')->ifFilterConvertFonction($item, 'Candidat');
            $this->get('core.index.controller_service')->ifFilterConvertAgence($item, 'Candidat');
        }

        return $this->render('@Core/User/Equipe/view.html.twig', array(
            'formView'                 => $this->createForm(UtilisateurType::class, new Utilisateur(), array('allow_extra_fields' => $this->get('core.index.controller_service')->generateListeChoices()))->createView(),
            'panel'                    => 'user', 'all' => $allItems,'is_archived' => 0, 'entity' => strtolower($this->get('core.index.controller_service')->checkFormEntity('Candidat')),
            'candidat_color'           => $this->get('core.index.controller_service')->colorForCandidatSlider($candidatListe[0]->getStartDate()->format("Y-m-d")),
            'session_messaging'        => $session_messaging, 'globalAlertColor' => $globalAlertColor, 'nb_candidat' => count($candidatListe),
            'currentUserInfos'         => $this->get('security.token_storage')->getToken()->getUser(),
            'userPhoto'                => $this->get('google.google_user_api_service')->base64safeToBase64(stream_get_contents($this->get('security.token_storage')->getToken()->getUser()->getPhoto())),
            'remaining_gmail_licenses' => $this->get('app.parameters_calls')->getParam('remaining_google_licenses'), 'remaining_salesforce_licenses' => $this->get('app.parameters_calls')->getParam('remaining_licences_type_Salesforce'),
        ));
    }
}