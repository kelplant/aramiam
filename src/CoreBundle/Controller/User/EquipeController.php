<?php
namespace CoreBundle\Controller\User;

use CoreBundle\Entity\Admin\Utilisateur;
use CoreBundle\Form\Admin\UtilisateurType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


/**
 * Class EquipeController
 * @package CoreBundle\Controller\User
 */
class EquipeController extends Controller
{
    private $isArchived;

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
     * @param $serviceId
     * @param $isArchived
     * @Route(path="/user/ajax/utilisateur/get/byservice/{serviceId}/{isArchived}",name="user_ajax_get_utilisateur_by_service")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function utilisateurGetInfosByServiceIndex($serviceId, $isArchived)
    {
        $fullInfos = $this->get('core.utilisateur_manager')->getRepository()->findBy(array('service' => $serviceId, 'isArchived' => $isArchived), array('viewName' => 'ASC'));
        $finalTab = [];
        foreach ($fullInfos as $item) {
            $finalTab[] = array('id' => $item->getId(), 'name' => $item->getViewName(), 'startDate' => $item->getStartDate()->format('d-m-Y'), 'agence' => $this->get('core.agence_manager')->load($item->getAgence())->getName(), 'service' => $this->get('core.service_manager')->load($item->getService())->getName(), 'fonction' => $this->get('core.fonction_manager')->load($item->getFonction())->getName());
        }
        return new JsonResponse($finalTab);
    }

    /**
     * @param $myProfil
     * @param $isArchived
     * @return array
     */
    private function generateItemsList($myProfil, $isArchived)
    {
        $allItems = $this->get('core.utilisateur_manager')->getRepository()->findBy(array('isArchived' => $isArchived, 'responsable' => $myProfil->getId()), array('startDate' => 'DESC'));
        foreach ($allItems as $item) {
            $this->get('core.index.controller_service')->ifFilterConvertService($item, 'Candidat');
            $this->get('core.index.controller_service')->ifFilterConvertFonction($item, 'Candidat');
            $this->get('core.index.controller_service')->ifFilterConvertAgence($item, 'Candidat');
        }
        return $allItems;
    }

    /**
     * @param $serviceId
     * @param $lvl
     * @param $isArchived
     * @return mixed
     */
    private function generateTree($serviceId, $lvl, $isArchived)
    {
        $this->isArchived = $isArchived;

        $options          = array(
            'decorate'      => true,
            'rootOpen'      => '<ul id="tree3">',
            'rootClose'     => '</ul>',
            'childOpen'     => '<li>',
            'childClose'    => '</li>',
            'childSort'     => array('name' => 'asc'),
            'nodeDecorator' => function($node) {
                return '<a href="#" onclick="showUtilisateur('.$node['id'].', '.$this->isArchived.');">'.$node['name'].'</a>';
            }
        );

        return $this->get('core.service_manager')->generateTree($serviceId, $lvl, $options);
    }

    /**
     * @param $myProfil
     * @param $isArchived
     * @return string
     */
    private function prepareTree($myProfil, $isArchived)
    {
        $initialList = $this->get('core.manager_service_link_manager')->getlist($myProfil->getId());
        $finalTree = '';
        foreach ($initialList as $branch) {
            $finalTree .= $this->generateTree($branch['id'], null, $isArchived);
        }
        return $finalTree;

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

        return $this->render('@Core/User/Equipe/view.html.twig', array(
            'manager'                  => $this->get('core.manager_service_link_manager')->isManager($myProfil->getId()),
            'formView'                 => $this->createForm(UtilisateurType::class, new Utilisateur(), array('allow_extra_fields' => $this->get('core.index.controller_service')->generateListeChoices()))->createView(),
            'panel'                    => 'user', 'all' => $this->generateItemsList($myProfil, $isArchived),'is_archived' => 0, 'entity' => strtolower($this->get('core.index.controller_service')->checkFormEntity('Candidat')),
            'candidat_color'           => $this->get('core.index.controller_service')->colorForCandidatSlider($candidatListe[0]->getStartDate()->format("Y-m-d")),
            'session_messaging'        => $session_messaging, 'globalAlertColor' => $globalAlertColor, 'nb_candidat' => count($candidatListe),
            'currentUserInfos'         => $this->get('security.token_storage')->getToken()->getUser(),
            'userPhoto'                => $this->get('google.google_user_api_service')->base64safeToBase64(stream_get_contents($this->get('security.token_storage')->getToken()->getUser()->getPhoto())),
            'remaining_gmail_licenses' => $this->get('app.parameters_calls')->getParam('remaining_google_licenses'), 'remaining_salesforce_licenses' => $this->get('app.parameters_calls')->getParam('remaining_licences_type_Salesforce'),
            'serviceList'              => $this->prepareTree($myProfil, $isArchived), 'isArchived' => $isArchived
        ));
    }
}