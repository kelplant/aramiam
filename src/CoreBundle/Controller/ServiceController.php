<?php

namespace CoreBundle\Controller;

use CoreBundle\Form\ServiceType;
use CoreBundle\Entity\Service;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ServiceController extends Controller
{
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
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $this->initData();
        return $this->get('core.controller_service')->generateIndexAction();
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Request $request)
    {
        $this->initData();
        return $this->get('core.controller_service')->generateDeleteAction($request, $this->get('core.controller_service')->getEntity());
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request)
    {
        $this->initData();
        return $this->get('core.controller_service')->generateAddAction($request, $this->get('core.controller_service')->getEntity());
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request)
    {
        $this->initData();
        return $this->get('core.controller_service')->generateEditAction($request, $this->get('core.controller_service')->getEntity());
    }
}