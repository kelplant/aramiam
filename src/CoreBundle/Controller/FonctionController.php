<?php

namespace CoreBundle\Controller;

use CoreBundle\Form\Admin\FonctionType;
use CoreBundle\Entity\Admin\Fonction;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class FonctionController
 * @package CoreBundle\Controller
 */
class FonctionController extends Controller
{
    private $itemToTemove;

    /**
     *
     */
    private function initData($service)
    {
        $this->get('core.'.$service.'.controller_service')->setMessage('');
        $this->get('core.'.$service.'.controller_service')->setInsert('');
        $this->get('core.'.$service.'.controller_service')->setEntity('Fonction');
        $this->get('core.'.$service.'.controller_service')->setNewEntity(Fonction::class);
        $this->get('core.'.$service.'.controller_service')->setFormType(FonctionType::class);
        $this->get('core.'.$service.'.controller_service')->setAlertText('cette fonction');
        $this->get('core.'.$service.'.controller_service')->setIsArchived(NULL);
        $this->get('core.'.$service.'.controller_service')->setCreateFormArguments(array());
    }

    /**
     * @Route(path="/admin/fonctions", name="liste_des_fonctions")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $this->initData('index');
        return $this->get('core.index.controller_service')->generateIndexAction(NULL);
    }

    /**
     * @param Request $request
     * @Route(path="/admin/fonctions/delete/{itemDelete}", name="remove_fonction")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Request $request)
    {
        $this->initData("delete");
        $this->itemToTemove = $request->get('itemDelete');
        $this->get('core.delete.controller_service')->setRemove($this->get('core.fonction_manager')->remove($this->itemToTemove));
        return $this->get('core.delete.controller_service')->generateDeleteAction();
    }

    /**
     * @param Request $request
     * @Route(path="/admin/fonction/add", name="form_exec_add_fonction")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function form_exec_addAction(Request $request)
    {
        $this->initData("add");
        return $this->get('core.add.controller_service')->executeRequestAddAction($request);
    }

    /**
     * @param Request $request
     * @Route(path="/admin/fonction/edit", name="form_exec_edit_fonction")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function form_exec_editAction(Request $request)
    {
        $this->initData('edit');
        return $this->get('core.edit.controller_service')->executeRequestEditAction($request);
    }
}