<?php
namespace CoreBundle\Controller;

use CoreBundle\Form\Admin\UtilisateurType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request as Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class UtilisateurController
 * @package CoreBundle\Controller
 */
class UtilisateurController extends Controller
{
    private $isArchived;

    /**
     * @return array
     */
    private function generateListeChoices()
    {
        $listeChoices = [];
        $listeChoices['listeFonctions'] = $this->get("core.fonction_manager")->createList();
        $listeChoices['listeAgences'] = $this->get("core.agence_manager")->createList();
        $listeChoices['listeServices'] = $this->get("core.service_manager")->createList();

        return $listeChoices;
    }

    /**
     *
     */
    private function initData()
    {
        $this->isArchived = Request::createFromGlobals()->query->get('isArchived', 0);

        $this->get('core.controller_service')->setMessage('');
        $this->get('core.controller_service')->setInsert('');
        $this->get('core.controller_service')->setEntity('Utilisateur');
        $this->get('core.controller_service')->setNewEntity('CoreBundle\Entity\Admin\Utilisateur');
        $this->get('core.controller_service')->setFormType(UtilisateurType::class);
        $this->get('core.controller_service')->setAlertText('cet utilisateur');
        $this->get('core.controller_service')->setIsArchived($this->isArchived);
        $this->get('core.controller_service')->setCreateFormArguments(array('allow_extra_fields' => $this->generateListeChoices()));
    }

    /**
     * @Route(path="/admin/utilisateur", name="liste_des_utilisateurs")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $this->initData();
        return $this->get('core.controller_service')->getFullList($this->isArchived);
    }

    /**
     * @param Request $request
     * @Route(path="/admin/utilisateur/delete", name="remove_utilisateur")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Request $request)
    {
        $this->initData();
        $this->get('core.controller_service')->setRemove($this->get('core.utilisateur_manager')->removeCandidat($request->query->get('itemDelete'), $request->query->get('isArchived')));
        return $this->get('core.controller_service')->generateDeleteAction();
    }

    /**
     * @param Request $request
     * @Route(path="/admin/utilisateur/add", name="form_exec_add_utilisateur")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function form_exec_addAction(Request $request)
    {
        $this->initData();
        return $this->get('core.controller_service')->executeRequestAddAction($request);
    }

    /**
     * @param Request $request
     * @Route(path="/admin/utilisateur/edit", name="form_exec_edit_utilisateur")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function form_exec_editAction(Request $request)
    {
        $this->initData();
        return $this->get('core.controller_service')->executeRequestEditAction($request);
    }
}