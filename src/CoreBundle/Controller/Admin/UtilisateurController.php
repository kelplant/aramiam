<?php
namespace CoreBundle\Controller\Admin;

use CoreBundle\Entity\Admin\Utilisateur;
use CoreBundle\Form\Admin\UtilisateurType;
use CoreBundle\Services\Core\AbstractControllerService;
use Symfony\Component\HttpFoundation\Request as Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class UtilisateurController
 * @package CoreBundle\Controller
 */
class UtilisateurController extends AbstractControllerService
{
    /**
     *
     */
    private function initData($service)
    {
        $this->selfInit('Utilisateur', 'core', Utilisateur::class, UtilisateurType::class, array('allow_extra_fields' => $this->generateListeChoices()));
        $this->isArchived = Request::createFromGlobals()->query->get('isArchived', 0);
        $this->get('core.'.$service.'.controller_service')->setEntity($this->entity);
        $this->get('core.'.$service.'.controller_service')->setNewEntity($this->newEntity);
        $this->get('core.'.$service.'.controller_service')->setFormType($this->formType);
        $this->get('core.'.$service.'.controller_service')->setAlertText('cet utilisateur');
        $this->get('core.'.$service.'.controller_service')->setIsArchived($this->isArchived);
        $this->get('core.'.$service.'.controller_service')->setCreateFormArguments($this->createFormArguments);
        $this->get('core.'.$service.'.controller_service')->setServicePrefix($this->servicePrefix);
    }

    /**
     * @Route(path="/admin/utilisateur", name="liste_des_utilisateurs")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $this->initData('index');

        return $this->get('core.index.controller_service')->generateIndexAction($this->isArchived);
    }

    /**
     * @param Request $request
     * @Route(path="/admin/utilisateur/delete", name="remove_utilisateur")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Request $request)
    {
        $this->initData('delete');
        $this->initData('index');
        $this->get('core.utilisateur_manager')->removeCandidat($request->query->get('itemDelete'), $request->query->get('isArchived'));

        if ($request->query->get('isArchived') == '0') {
            $this->get('odigo.odigo_api_service')->deleteOdigoUser($request->request->get('sendaction'), $request, $request->request->get('utilisateur')['id'], $this->getParameter('odigo'), $this->getParameter('google_api'), $this->getParameter('salesforce'));
            $this->get('salesforce.salesforce_api_user_service')->ActiveDesactiveSalesforceAccount($request, $this->getParameter('salesforce'), false);
            $this->get('ad.active_directory_api_user_service')->deleteUserFromAD($this->getParameter('active_directory'), $request->request->get('utilisateur')['id']);
        } elseif ($request->query->get('isArchived') == '1') {
           //Activate
        }

        return $this->get('core.delete.controller_service')->generateDeleteAction();
    }

    /**
     * @param Request $request
     * @Route(path="/admin/utilisateur/add", name="form_exec_add_utilisateur")
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
     * @Route(path="/admin/utilisateur/edit", name="form_exec_edit_utilisateur")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function form_exec_editAction(Request $request)
    {
        $this->initData('index');
        $this->formAdd = $this->generateForm();
        $this->formEdit = $this->generateForm();
        $this->formEdit->handleRequest($request);
        if ($this->formEdit->isSubmitted() && $this->formEdit->isValid()) {
            if ($request->request->get('formAction') == 'edit') {
                $this->saveEditIfSaveOrTransform($request->request->get('sendAction'), $request);
                $this->retablirOrTransformArchivedItem($request->request->get('sendAction'), $request);
                $this->get('google.google_user_api_service')->ifGmailCreate($request->request->get('sendaction'), $request->request->get('utilisateur')['isCreateInGmail'], $request, $this->getParameter('google_api'));
                $this->get('odigo.odigo_api_service')->ifOdigoCreate($request->request->get('sendaction'), $request, $this->getParameter('odigo'), $this->getParameter('google_api'), $this->getParameter('salesforce'));
                $this->get('odigo.odigo_api_service')->deleteOdigoUser($request->request->get('sendaction'), $request, $request->request->get('utilisateur')['id'], $this->getParameter('odigo'), $this->getParameter('google_api'), $this->getParameter('salesforce'));
                $this->get('ad.active_directory_api_user_service')->ifWindowsCreate($request->request->get('sendaction'), $request->request->get('utilisateur')['isCreateInWindows'], $request, $this->getParameter('active_directory'));
                $this->get('ad.active_directory_api_user_service')->ifWindowsUpdate($request->request->get('sendaction'), $request, $this->getParameter('active_directory'));
                $this->get('salesforce.salesforce_api_user_service')->ifSalesforceCreate($request->request->get('sendaction'), $request, $this->getParameter('salesforce'));
                $this->get('salesforce.salesforce_api_user_service')->ifSalesforceProfilUpdated($request->request->get('sendaction'), $request, $this->getParameter('salesforce'));
                $this->get('salesforce.salesforce_api_user_service')->IfSalesforceDesactivateAccount($request->request->get('sendaction'), $request, $this->getParameter('salesforce'));
                $this->get('salesforce.salesforce_api_user_service')->IfSalesforceActivateAccount($request->request->get('sendaction'), $request, $this->getParameter('salesforce'));
            }
        }
        return $this->get('core.index.controller_service')->getFullList($this->isArchived, $this->formAdd, $this->formEdit);
    }
}