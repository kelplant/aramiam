<?php
namespace CoreBundle\Controller;

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
    private function initData()
    {
        $this->get('core.controller_service')->setMessage('');
        $this->get('core.controller_service')->setInsert('');
        $this->get('core.controller_service')->setEntity('EntiteHolding');
        $this->get('core.controller_service')->setNewEntity(EntiteHolding::class);
        $this->get('core.controller_service')->setFormType(EntiteHoldingType::class);
        $this->get('core.controller_service')->setAlertText('cette entité');
        $this->get('core.controller_service')->setIsArchived(NULL);
        $this->get('core.controller_service')->setCreateFormArguments(array());
    }

    /**
     * @Route(path="/admin/entite_holding", name="liste_des_entites_holding")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $this->initData();
        return $this->get('core.controller_service')->getFullList(NULL);
    }

    /**
     * @param Request $request
     * @Route(path="/admin/entiteholding/delete/{itemDelete}", defaults={"delete" = 0} , name="remove_entiteholding")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Request $request)
    {
        $this->initData();
        $this->itemToTemove = $request->get('itemDelete');
        $this->get('core.controller_service')->setRemove($this->get('core.entite_holding_manager')->remove($this->itemToTemove));
        return $this->get('core.controller_service')->generateDeleteAction();
    }

    /**
     * @param Request $request
     * @Route(path="/admin/entiteholding/add", name="form_exec_add_entiteholding")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function form_exec_addAction(Request $request)
    {
        $this->initData();
        return $this->get('core.controller_service')->executeRequestAddAction($request);
    }

    /**
     * @param Request $request
     * @Route(path="/admin/entiteholding/edit", name="form_exec_edit_entiteholding")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function form_exec_editAction(Request $request)
    {
        $this->initData();
        return $this->get('core.controller_service')->executeRequestEditAction($request);
    }
}