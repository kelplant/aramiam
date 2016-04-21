<?php
namespace CoreBundle\Controller\Admin;

use CoreBundle\Entity\Admin\Candidat;
use CoreBundle\Form\Admin\CandidatType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request as Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class CandidatController
 * @package CoreBundle\Controller
 */
class CandidatController extends Controller
{
    private $isArchived;

    /**
     *
     */
    private function initData($service)
    {
        $this->isArchived = Request::createFromGlobals()->query->get('isArchived', 0);

        $this->get('core.'.$service.'.controller_service')->setMessage('');
        $this->get('core.'.$service.'.controller_service')->setInsert('');
        $this->get('core.'.$service.'.controller_service')->setEntity('Candidat');
        $this->get('core.'.$service.'.controller_service')->setNewEntity(Candidat::class);
        $this->get('core.'.$service.'.controller_service')->setFormType(CandidatType::class);
        $this->get('core.'.$service.'.controller_service')->setAlertText('ce candidat');
        $this->get('core.'.$service.'.controller_service')->setIsArchived($this->isArchived);
        $this->get('core.'.$service.'.controller_service')->setCreateFormArguments(array('allow_extra_fields' => $this->get('core.'.$service.'.controller_service')->generateListeChoices()));
        $this->get('core.'.$service.'.controller_service')->setServicePrefix('core');
    }

    /**
     * @param $isArchived
     * @param $request
     * @return mixed|null
     */
    private function deleteOrArchive($isArchived, $request)
    {
        if ($isArchived == 0) {
            if (is_null($this->get('zendesk.zendesk_ticket_link_manager')->getNumTicket($request->query->get('itemDelete'))) === false) {
                return $this->get('zendesk.zendesk_service')->deleteTicket($this->get('zendesk.zendesk_ticket_link_manager')->getNumTicket($request->query->get('itemDelete'))->getTicketId(), $this->getParameter('zendesk_api'));
            } else {
                return null;
            }
        } elseif ($isArchived == 1) {
            return $this->get('core.add.controller_service')->executeCreateTicket($this->get('core.candidat_manager')->loadCandidat($request->query->get('itemDelete')), $this->getParameter('zendesk_api'));
        } else {
            return null;
        }
    }

    /**
     * @Route(path="/admin/candidat", name="liste_des_candidats")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $this->initData('index');
        return $this->get('core.index.controller_service')->generateIndexAction($this->isArchived);
    }

    /**
     * @param Request $request
     * @Route(path="/admin/candidat/delete", name="remove_candidat")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Request $request)
    {
        $this->initData('delete');
        $this->initData('index');
        $this->get('core.delete.controller_service')->setRemove($this->get('core.candidat_manager')->removeCandidat($request->query->get('itemDelete'), $request->query->get('isArchived')));
        $this->deleteOrArchive($request->query->get('isArchived'), $request);

        return $this->get('core.delete.controller_service')->generateDeleteAction();
    }

    /**
     * @param Request $request
     * @Route(path="/admin/candidat/add", name="form_exec_add_candidat")
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
     * @Route(path="/admin/candidat/edit", name="form_exec_edit_candidat")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function form_exec_editAction(Request $request)
    {
        $this->initData('edit');
        $this->initData('index');
        if (is_null($this->get('zendesk.zendesk_ticket_link_manager')->getNumTicket($request->request->get('candidat')['id'])) === false) {
            $this->get('zendesk.zendesk_service')->updateStartDateTicket($this->get('zendesk.zendesk_ticket_link_manager')->getNumTicket($request->request->get('candidat')['id'])->getTicketId(), date("Y-m-d", strtotime($request->request->get('candidat')['startDate'])), $this->getParameter('zendesk_api'));
        }

        return $this->get('core.edit.controller_service')->executeRequestEditAction($request);
    }

    /**
     * @param $candidatEdit
     * @Route(path="/ajax/candidat/get/{candidatEdit}",name="ajax_get_candidat")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function candidatGetInfosIndex($candidatEdit)
    {
        return new JsonResponse($this->get('core.candidat_manager')->createArray($candidatEdit));
    }
}