<?php

namespace CoreBundle\Controller;

use CoreBundle\Form\FonctionType;
use CoreBundle\Entity\Fonction;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class FonctionController extends Controller
{
    private $itemToTemove;

    /**
     *
     */
    private function initData()
    {
        $this->get('core.controller_service')->setMessage('');
        $this->get('core.controller_service')->setInsert('');
        $this->get('core.controller_service')->setEntity('Fonction');
        $this->get('core.controller_service')->setNewEntity(Fonction::class);
        $this->get('core.controller_service')->setFormType(FonctionType::class);
        $this->get('core.controller_service')->setAlertText('cette fonction');
        $this->get('core.controller_service')->setIsArchived(NULL);
        $this->get('core.controller_service')->setCriteria(array());
        $this->get('core.controller_service')->setOrderBy(array('name' => 'ASC'));
        $this->get('core.controller_service')->setCreateFormArguments(array());
    }

    /**
     * @Route(path="/admin/fonctions", name="liste_des_fonctions")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $this->initData();
        return $this->get('core.controller_service')->generateIndexAction();
    }

    /**
     * @param Request $request
     * @Route(path="/admin/fonctions/delete/{itemDelete}", name="remove_fonction")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Request $request)
    {
        $this->initData();
        $this->itemToTemove = $request->get('itemDelete');
        $this->get('core.controller_service')->setRemove($this->get('core.fonction_manager')->remove($this->itemToTemove));
        return $this->get('core.controller_service')->generateDeleteAction();
    }

    /**
     * @param Request $request
     * @Route(path="/admin/fonctions/add", name="add_fonction")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request)
    {
        $this->initData();
        return $this->get('core.controller_service')->generateAddAction($request);
    }

    /**
     * @param Request $request
     * @Route(path="/admin/fonctions/edit/{itemEdit}", defaults={"itemEdit" = 0} , name="edit_fonction")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request)
    {
        $this->initData();
        $item = $this->get('core.fonction_manager')->getRepository()->findOneById($request->get('itemEdit'));
        $this->get('core.controller_service')->setFormItem($item);
        return $this->get('core.controller_service')->generateEditAction($request);
    }
}