<?php

namespace CoreBundle\Controller\Applications\Odigo;

use CoreBundle\Entity\Applications\Odigo\OdigoTelListe;
use CoreBundle\Form\Applications\Odigo\OdigoTelListeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class OdigoTelListeController
 * @package CoreBundle\Controller
 */
class OdigoTelListeController extends Controller
{
    private $itemToTemove;

    /**
     *
     */
    private function initData($service)
    {
        $this->get('core.'.$service.'.controller_service')->setMessage('');
        $this->get('core.'.$service.'.controller_service')->setInsert('');
        $this->get('core.'.$service.'.controller_service')->setEntity('OdigoTelListe');
        $this->get('core.'.$service.'.controller_service')->setNewEntity(OdigoTelListe::class);
        $this->get('core.'.$service.'.controller_service')->setFormType(OdigoTelListeType::class);
        $this->get('core.'.$service.'.controller_service')->setAlertText('cet numéro Odigo');
        $this->get('core.'.$service.'.controller_service')->setIsArchived(NULL);
        $this->get('core.'.$service.'.controller_service')->setCreateFormArguments(array('allow_extra_fields' => $this->get('core.'.$service.'.controller_service')->generateListeChoices()));
    }

    /**
     * @Route(path="/app/odigo/odigo_tel_liste", name="odigo_tel_liste")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $this->initData('index');
        return $this->get('core.index.controller_service')->generateIndexAction(NULL);
    }

    /**
     * @param Request $request
     * @Route(path="/app/odigo/odigo_tel_liste/delete/{itemDelete}", defaults={"delete" = 0} , name="remove_odigotelliste")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Request $request)
    {
        $this->initData('delete');
        $this->initData('index');
        $this->itemToTemove = $request->get('itemDelete');
        $this->get('core.delete.controller_service')->setRemove($this->get('core.odigotelliste_manager')->remove($this->itemToTemove));
        return $this->get('core.delete.controller_service')->generateDeleteAction();
    }

    /**
     * @param Request $request
     * @Route(path="/app/odigo/odigo_tel_liste/add", name="form_exec_add_odigo_tel_liste")
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
     * @Route(path="/app/odigo/odigo_tel_liste/edit", name="form_exec_edit_odigo_tel_liste")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function form_exec_editAction(Request $request)
    {
        $this->initData('edit');
        $this->initData('index');
        return $this->get('core.edit.controller_service')->executeRequestEditAction($request);
    }
}