<?php

namespace CoreBundle\Controller;

use CoreBundle\Entity\Admin\Agence;
use CoreBundle\Form\Admin\AgenceType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class AgenceController
 * @package CoreBundle\Controller
 */
class AgenceController extends Controller
{
    private $itemToTemove;

    /**
     *
     */
    private function initData()
    {
        $this->get('core.controller_service')->setMessage('');
        $this->get('core.controller_service')->setInsert('');
        $this->get('core.controller_service')->setEntity('Agence');
        $this->get('core.controller_service')->setNewEntity(Agence::class);
        $this->get('core.controller_service')->setFormType(Agencetype::class);
        $this->get('core.controller_service')->setAlertText('cette agence');
        $this->get('core.controller_service')->setIsArchived(NULL);
        $this->get('core.controller_service')->setCreateFormArguments(array());
    }

    /**
     * @Route(path="/admin/agences", name="liste_des_agences")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $this->initData();
        return $this->get('core.controller_service')->getFullList(NULL);
    }

    /**
     * @param Request $request
     * @Route(path="/admin/agences/delete/{itemDelete}", defaults={"delete" = 0} , name="remove_agence")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Request $request)
    {
        $this->initData();
        $this->itemToTemove = $request->get('itemDelete');
        $this->get('core.controller_service')->setRemove($this->get('core.agence_manager')->remove($this->itemToTemove));
        return $this->get('core.controller_service')->generateDeleteAction();
    }

    /**
     * @param Request $request
     * @Route(path="/admin/agences/add", name="form_exec_add_agence")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function form_exec_addAction(Request $request)
    {
        $this->initData();
        return $this->get('core.controller_service')->executeRequestAddAction($request);
    }

    /**
     * @param Request $request
     * @Route(path="/admin/agences/edit", name="form_exec_edit_agence")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function form_exec_editAction(Request $request)
    {
        $this->initData();
        return $this->get('core.controller_service')->executeRequestEditAction($request);
    }
}