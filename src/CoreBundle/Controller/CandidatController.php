<?php
namespace CoreBundle\Controller;

use CoreBundle\Entity\Admin\Candidat;
use CoreBundle\Form\Admin\CandidatType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request as Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use DateTime;

/**
 * Class CandidatController
 * @package CoreBundle\Controller
 */
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
        $listeChoices['listeUtilisateurs'] = $this->get("core.utilisateur_manager")->createList();

        return $listeChoices;
    }

    /**
     * @param $isArchived
     * @param $request
     * @return mixed|null
     */
    private function deleteOrArchive($isArchived, $request)
    {
        if ($isArchived == 0) {
            if(is_null($this->get('core.app_zendesk_ticket_link_manager')->getNumTicket($request->query->get('itemDelete'))) == false) {
                return $this->get('core.zendesk_service')->deleteTicket($this->get('core.app_zendesk_ticket_link_manager')->getNumTicket($request->query->get('itemDelete'))->getTicketId());
            } else {
                return null;
            }
        } elseif ($isArchived == 1) {
            return $this->get('core.controller_service')->executeCreateTicket($this->get('core.candidat_manager')->loadCandidat($request->query->get('itemDelete')));
        } else {
            return null;
        }
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
        $this->deleteOrArchive($request->query->get('isArchived'), $request);

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
        if(is_null($this->get('core.app_zendesk_ticket_link_manager')->getNumTicket($request->request->get('candidat')['id'])) == false){
            $this->get('core.zendesk_service')->updateStartDateTicket($this->get('core.app_zendesk_ticket_link_manager')->getNumTicket($request->request->get('candidat')['id'])->getTicketId(), date("Y-m-d", strtotime($request->request->get('candidat')['startDate'])));
        }

        return $this->get('core.controller_service')->executeRequestEditAction($request);
    }
}