<?php

namespace CoreBundle\Controller;

use CoreBundle\Form\CandidatType;
use CoreBundle\Entity\Candidat;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CandidatController extends Controller
{

    private $isArchived;

    /**
     * CandidatController constructor.
     */
    public function __construct()
    {
        $path = Request::createFromGlobals()->getPathInfo();
        if ($path == '/admin/candidats')
        {
            $this->isArchived = '0';
        }
        if ($path == '/admin/candidats/archived')
        {
            $this->isArchived = '1';
        }
        $isArchived = Request::createFromGlobals()->get('isArchived');
        if (isset($isArchived))
        {
            $this->isArchived = $isArchived;
        }
    }

    /**
     *
     */
    private function initData()
    {
        $this->get('core.controller_service')->setMessage('');
        $this->get('core.controller_service')->setInsert('');
        $this->get('core.controller_service')->setEntity('Candidat');
        $this->get('core.controller_service')->setNewEntity(Candidat::class);
        $this->get('core.controller_service')->setFormType(CandidatType::class);
        $this->get('core.controller_service')->setAlertText('ce candidat');
        $this->get('core.controller_service')->setIsArchived($this->isArchived);
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