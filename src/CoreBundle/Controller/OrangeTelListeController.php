<?php

namespace CoreBundle\Controller;

use CoreBundle\Entity\Applications\Odigo\OrangeTelListe;
use CoreBundle\Form\Applications\Odigo\OrangeTelListeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class OrangeTelListeController
 * @package CoreBundle\Controller
 */
class OrangeTelListeController extends Controller
{
    private $itemToTemove;

    /**
     *
     */
    private function initData($service)
    {
        $this->get('core.'.$service.'.controller_service')->setMessage('');
        $this->get('core.'.$service.'.controller_service')->setInsert('');
        $this->get('core.'.$service.'.controller_service')->setEntity('OrangeTelListe');
        $this->get('core.'.$service.'.controller_service')->setNewEntity(OrangeTelListe::class);
        $this->get('core.'.$service.'.controller_service')->setFormType(OrangeTelListeType::class);
        $this->get('core.'.$service.'.controller_service')->setAlertText('cet numéro Orange');
        $this->get('core.'.$service.'.controller_service')->setIsArchived(NULL);
        $this->get('core.'.$service.'.controller_service')->setCreateFormArguments(array());
    }

    /**
     * @Route(path="/app/odigo/orange_tel_liste", name="orange_tel_liste")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $this->initData('index');
        return $this->get('core.index.controller_service')->generateIndexAction(NULL);
    }

    /**
     * @param Request $request
     * @Route(path="/app/odigo/orange_tel_liste/delete/{itemDelete}", defaults={"delete" = 0} , name="remove_orangetelliste")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Request $request)
    {
        $this->initData('index');
        return $this->get('core.index.controller_service')->generateIndexAction(NULL);
    }

    /**
     * @param Request $request
     * @Route(path="/app/odigo/orange_tel_liste/add", name="form_exec_add_orange_tel_liste")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function form_exec_addAction(Request $request)
    {
        $this->initData('index');
        return $this->get('core.index.controller_service')->generateIndexAction(NULL);
    }

    /**
     * @param Request $request
     * @Route(path="/app/odigo/orange_tel_liste/edit", name="form_exec_edit_orange_tel_liste")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function form_exec_editAction(Request $request)
    {
        $this->initData('index');
        return $this->get('core.index.controller_service')->generateIndexAction(NULL);
    }
}