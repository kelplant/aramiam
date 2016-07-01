<?php

namespace OdigoApiBundle\Controller;

use OdigoApiBundle\Entity\OrangeTelListe;
use OdigoApiBundle\Form\OrangeTelListeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class OrangeTelListeController
 * @package OdigoApiBundle\Controller
 */
class OrangeTelListeController extends Controller
{
    private $itemToTemove;

    /**
     *
     */
    private function initData($service)
    {
        $this->get('core.'.$service.'.controller_service')->setEntity('OrangeTelListe');
        $this->get('core.'.$service.'.controller_service')->setNewEntity(OrangeTelListe::class);
        $this->get('core.'.$service.'.controller_service')->setFormType(OrangeTelListeType::class);
        $this->get('core.'.$service.'.controller_service')->setAlertText('cet numéro Orange');
        $this->get('core.'.$service.'.controller_service')->setIsArchived(NULL);
        $this->get('core.'.$service.'.controller_service')->setCreateFormArguments(array('allow_extra_fields' => $this->get('core.'.$service.'.controller_service')->generateListeChoices()));
        $this->get('core.'.$service.'.controller_service')->setServicePrefix('odigo');
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
        $this->initData('delete');
        $this->initData('index');
        $this->itemToTemove = $request->get('itemDelete');
        $this->get('odigo.orangetelliste_manager')->remove($this->itemToTemove);
        return $this->get('core.delete.controller_service')->generateDeleteAction();
    }

    /**
     * @param Request $request
     * @Route(path="/app/odigo/orange_tel_liste/add", name="form_exec_add_orange_tel_liste")
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
     * @Route(path="/app/odigo/orange_tel_liste/edit", name="form_exec_edit_orange_tel_liste")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function form_exec_editAction(Request $request)
    {
        $this->initData('edit');
        $this->initData('index');
        return $this->get('core.edit.controller_service')->executeRequestEditAction($request);
    }

    /**
     * @param $orangetellisteEdit
     * @Route(path="/ajax/orange_tel_liste/get/{orangetellisteEdit}",name="ajax_get_orangetelliste")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function orangeTelListeGetInfosIndex($orangetellisteEdit)
    {
        return new JsonResponse($this->get('odigo.orangetelliste_manager')->createArray($orangetellisteEdit));
    }

    /**
     * @param $service
     * @Route(path="/ajax/generate/orange/{service}",name="ajax_generate_orange")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function generateListPossibleTelOrangeIndex($service)
    {
        return new JsonResponse($this->get('odigo.orangetelliste_manager')->getAllTelForService($service));
    }
}