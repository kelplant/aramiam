<?php

namespace CoreBundle\Controller;

use CoreBundle\Form\AgenceType;
use CoreBundle\Entity\Agence;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AgenceController extends Controller
{
    /**
     *
     */
    private function initData()
    {
        $this->get('core.controller_service')->setMessage('');
        $this->get('core.controller_service')->setInsert('');
        $this->get('core.controller_service')->setEntity('Agence');
        $this->get('core.controller_service')->setNewEntity(Agence::class);
        $this->get('core.controller_service')->setFormType(AgenceType::class);
        $this->get('core.controller_service')->setAlertText('cette agence');
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