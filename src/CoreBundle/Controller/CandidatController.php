<?php

namespace CoreBundle\Controller;

use CoreBundle\Form\CandidatType;
use CoreBundle\Entity\Admin\Candidat;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request as Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class CandidatController extends Controller
{
    private $isArchived;

    private $itemToTemove;

    private $reqcase;

    /**
     * @return array
     */
    private function generateListeChoices()
    {
        $listeChoices = [];
        $listeChoices['listeFonctions'] = $this->get("core.fonction_manager")->createList();
        $listeChoices['listeAgences'] = $this->get("core.agence_manager")->createList();
        $listeChoices['listeServices'] = $this->get("core.service_manager")->createList();

        return $listeChoices;
    }

    /**
     *
     */
    private function initData()
    {
        $this->isArchived = Request::createFromGlobals()->query->get('isArchived', 0);

        $this->get('core.controller_service')->setMessage('');
        $this->get('core.controller_service')->setInsert('');
        $this->get('core.controller_service')->setEntity('Candidat');
        $this->get('core.controller_service')->setNewEntity('CoreBundle\Entity\Admin\Candidat');
        $this->get('core.controller_service')->setFormType(CandidatType::class);
        $this->get('core.controller_service')->setAlertText('ce candidat');
        $this->get('core.controller_service')->setIsArchived($this->isArchived);
        $this->get('core.controller_service')->setCreateFormArguments(array('allow_extra_fields' => $this->generateListeChoices()));
        $allItems = $this->get('core.candidat_manager')->getRepository()->findBy(array('isArchived' => $this->isArchived), array('startDate' => 'DESC'));
        foreach ($allItems as $item) {
            $item->setStartDate($item->getStartDate()->format('d-m-Y'));
            $item->setAgence($this->get('core.agence_manager')->getRepository()->findOneById($item->getAgence())->getName());
            $item->setFonction($this->get('core.fonction_manager')->getRepository()->findOneById($item->getFonction())->getName());
            $item->setService($this->get('core.service_manager')->getRepository()->findOneById($item->getService())->getName());
        }
        $this->get('core.controller_service')->setAllItems($allItems);
    }

    /**
     * @Route(path="/admin/candidats", name="liste_des_candidats")
     * @Route(path="/admin/candidats/archived", name="liste_des_candidats_archives")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $this->initData();
        return $this->get('core.controller_service')->generateIndexAction();
    }

    /**
     * @param Request $request
     * @Route(path="/admin/candidats/delete", name="remove_candidat")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Request $request)
    {
        $this->initData();
        $this->itemToTemove = $this->itemToTemove = $request->get('itemDelete');
        $this->get('core.controller_service')->setRemove($this->get('core.candidat_manager')->removeCandidat($this->itemToTemove));
        return $this->get('core.controller_service')->generateDeleteAction();
    }

    /**
     * @param Request $request
     * @Route(path="/admin/candidats/add", name="add_candidat")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request)
    {
        $this->initData();
        return $this->get('core.controller_service')->generateAddAction($request);
    }

    /**
     * @param Request $request
     * @Route(path="/admin/candidats/edit/{itemEdit}", defaults={"itemEdit" = 0} , name="edit_candidat")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request)
    {
        $this->initData();
        $item = $this->get('core.candidat_manager')->getRepository()->findOneById($request->attributes->get('itemEdit'));
        var_dump($item);
        return $this->get('core.controller_service')->generateEditAction($request);
    }
}