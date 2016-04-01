<?php

namespace CoreBundle\Controller;

use CoreBundle\Form\ServiceType;
use CoreBundle\Entity\Admin\Service;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ServiceController extends Controller
{
    private $itemToTemove;

    /**
     *
     */
    private function initData()
    {
        $this->get('core.controller_service')->setMessage('');
        $this->get('core.controller_service')->setInsert('');
        $this->get('core.controller_service')->setEntity('Service');
        $this->get('core.controller_service')->setNewEntity(Service::class);
        $this->get('core.controller_service')->setFormType(ServiceType::class);
        $this->get('core.controller_service')->setAlertText('ce service');
        $this->get('core.controller_service')->setIsArchived(NULL);
        $this->get('core.controller_service')->setCreateFormArguments(array());
        $this->get('core.controller_service')->setAllItems($this->get('core.service_manager')->getRepository()->findBy(array(), array('name' => 'ASC')));
    }

    /**
     * @Route(path="/admin/services", name="liste_des_services")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $this->initData();
        return $this->get('core.controller_service')->generateIndexAction();
    }

    /**
     * @param Request $request
     * @Route(path="/admin/services/delete/{itemDelete}", defaults={"delete" = 0} , name="remove_service")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Request $request)
    {
        $this->initData();
        $this->itemToTemove = $request->get('itemDelete');
        $this->get('core.controller_service')->setRemove($this->get('core.service_manager')->remove($this->itemToTemove));
        return $this->get('core.controller_service')->generateDeleteAction();
    }

    /**
     * @param Request $request
     * @Route(path="/admin/services/add", name="add_service")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request)
    {
        $this->initData();
        return $this->get('core.controller_service')->generateAddAction($request);
    }

    /**
     * @param Request $request
     * @Route(path="/admin/services/edit/{itemEdit}", defaults={"itemEdit" = 0} , name="edit_service")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request)
    {
        $this->initData();
        $item = $this->get('core.service_manager')->getRepository()->findOneById($request->get('itemEdit'));
        $this->get('core.controller_service')->setFormItem($item);
        return $this->get('core.controller_service')->generateEditAction($request);
    }
}