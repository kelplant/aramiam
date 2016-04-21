<?php

namespace OdigoApiBundle\Controller;

use OdigoApiBundle\Entity\OdigoTelListe;
use OdigoApiBundle\Form\OdigoTelListeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class OdigoTelListeController
 * @package OdigoApiBundle\Controller
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
        $this->get('core.'.$service.'.controller_service')->setServicePrefix('odigo');
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
        $this->get('core.delete.controller_service')->setRemove($this->get('odigo.odigotelliste_manager')->remove($this->itemToTemove));
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

    /**
     * @param $odigotellisteEdit
     * @Route(path="/ajax/odigo_tel_liste/get/{odigotellisteEdit}",name="ajax_get_odigotelliste")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function odigoTelListeGetInfosIndex($odigotellisteEdit)
    {
        return new JsonResponse($this->get('odigo.odigotelliste_manager')->createArray($odigotellisteEdit));
    }

    /**
     * @param $service
     * @param $fonction
     * @Route(path="/ajax/generate/odigo/{service}/{fonction}",name="ajax_generate_odigo")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function generateListPossibleTelOdigoIndex($service, $fonction)
    {
        return new JsonResponse($this->get('odigo.odigotelliste_manager')->getAllTelForServiceAndFonction($service, $fonction));
    }
}