<?php
namespace CoreBundle\Controller\Admin;

use CoreBundle\Form\Admin\EntiteHoldingType;
use CoreBundle\Entity\Admin\EntiteHolding;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class ServiceController
 * @package CoreBundle\Controller
 */
class EntiteHoldingController extends Controller
{
    private $itemToTemove;

    /**
     *
     */
    private function initData($service)
    {
        $this->get('core.'.$service.'.controller_service')->setMessage('');
        $this->get('core.'.$service.'.controller_service')->setInsert('');
        $this->get('core.'.$service.'.controller_service')->setEntity('EntiteHolding');
        $this->get('core.'.$service.'.controller_service')->setNewEntity(EntiteHolding::class);
        $this->get('core.'.$service.'.controller_service')->setFormType(EntiteHoldingType::class);
        $this->get('core.'.$service.'.controller_service')->setAlertText('cette entité');
        $this->get('core.'.$service.'.controller_service')->setIsArchived(NULL);
        $this->get('core.'.$service.'.controller_service')->setCreateFormArguments(array());
    }

    /**
     * @Route(path="/admin/entite_holding", name="liste_des_entites_holding")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $this->initData('index');
        return $this->get('core.index.controller_service')->generateIndexAction(NULL);
    }

    /**
     * @param Request $request
     * @Route(path="/admin/entiteholding/delete/{itemDelete}", defaults={"delete" = 0} , name="remove_entiteholding")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Request $request)
    {
        $this->initData('delete');
        $this->initData('index');
        $this->itemToTemove = $request->get('itemDelete');
        $this->get('core.delete.controller_service')->setRemove($this->get('core.entite_holding_manager')->remove($this->itemToTemove));
        return $this->get('core.delete.controller_service')->generateDeleteAction();
    }

    /**
     * @param Request $request
     * @Route(path="/admin/entiteholding/add", name="form_exec_add_entiteholding")
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
     * @Route(path="/admin/entiteholding/edit", name="form_exec_edit_entiteholding")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function form_exec_editAction(Request $request)
    {
        $this->initData('edit');
        $this->initData('index');
        return $this->get('core.edit.controller_service')->executeRequestEditAction($request);
    }
}