<?php
namespace CoreBundle\Controller;

use CoreBundle\Entity\Admin\Candidat;
use CoreBundle\Form\Admin\CandidatType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request as Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use DateTime;

class CandidatController extends Controller
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
        $this->get('core.controller_service')->setEntity('Candidat');
        $this->get('core.controller_service')->setNewEntity('CoreBundle\Entity\Admin\Candidat');
        $this->get('core.controller_service')->setFormType(CandidatType::class);
        $this->get('core.controller_service')->setAlertText('ce candidat');
        $this->get('core.controller_service')->setIsArchived($this->isArchived);
        $this->get('core.controller_service')->setCreateFormArguments(array('allow_extra_fields' => $this->generateListeChoices()));
    }

    /**
     * @Route(path="/admin/candidat", name="liste_des_candidats")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $this->initData();
        return $this->get('core.controller_service')->getFullList($this->isArchived);
    }

    /**
     * @param Request $request
     * @Route(path="/admin/candidat/delete", name="remove_candidat")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Request $request)
    {
        $this->initData();
        $this->get('core.controller_service')->setRemove($this->get('core.candidat_manager')->removeCandidat($request->query->get('itemDelete'), $request->query->get('isArchived')));
        if ($request->query->get('isArchived') == 0){
            $this->get('core.zendesk_service')->deleteTicket($this->get('core.app_zendesk_ticket_link_manager')->getNumTicket($request->query->get('itemDelete'))->getTicketId());
        } elseif ($request->query->get('isArchived') == 1){
            $this->get('core.controller_service')->executeCreateTicket($this->get('core.candidat_manager')->load($request->query->get('itemDelete')));
        }

        return $this->get('core.controller_service')->generateDeleteAction();
    }

    /**
     * @param Request $request
     * @Route(path="/admin/candidat/add", name="form_exec_add_candidat")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function form_exec_addAction(Request $request)
    {
        $this->initData();
        return $this->get('core.controller_service')->executeRequestAddAction($request);
    }

    /**
     * @param Request $request
     * @Route(path="/admin/candidat/edit", name="form_exec_edit_candidat")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function form_exec_editAction(Request $request)
    {
        $this->initData();
        return $this->get('core.controller_service')->executeRequestEditAction($request);
    }
}