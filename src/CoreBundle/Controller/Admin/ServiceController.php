<?php
namespace CoreBundle\Controller\Admin;

use CoreBundle\Form\Admin\ServiceType;
use CoreBundle\Entity\Admin\Service;
use CoreBundle\Services\Core\AbstractControllerService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class ServiceController
 * @package CoreBundle\Controller
 */
class ServiceController extends AbstractControllerService
{
    private $itemToTemove;

    /**
     *
     */
    private function selfInit()
    {
        $this->entity = 'Service';
        $this->servicePrefix = 'core';
        $this->newEntity = Service::class;
        $this->formType = ServiceType::class;
        $this->createFormArguments = array('allow_extra_fields' => $this->generateListeChoices());
    }

    /**
     *
     */
    private function initData($service)
    {
        $this->selfInit();
        $this->get('core.'.$service.'.controller_service')->setEntity($this->entity);
        $this->get('core.'.$service.'.controller_service')->setNewEntity($this->newEntity);
        $this->get('core.'.$service.'.controller_service')->setFormType($this->formType);
        $this->get('core.'.$service.'.controller_service')->setAlertText('ce service');
        $this->get('core.'.$service.'.controller_service')->setIsArchived(NULL);
        $this->get('core.'.$service.'.controller_service')->setCreateFormArguments($this->createFormArguments);
        $this->get('core.'.$service.'.controller_service')->setServicePrefix($this->servicePrefix);
    }

    /**
     * @param $request
     */
    private function ifSfTerritoryPresentInServiceAdd($request)
    {
        if ($request->request->get('salesforce') != '') {
            $this->get('salesforce.territory_to_service_manager')->deleteForServiceId($request->request->get('service')['id']);
            foreach ($request->request->get('salesforce') as $key => $value) {
                if (substr($key, 0, 9) == 'territory') {
                    $this->get('salesforce.territory_to_service_manager')->add(array('salesforceTerritoryId' => $value, 'serviceId' => $request->request->get('service')['id']));
                }
            }
        }
    }

    /**
     * @Route(path="/admin/services", name="liste_des_services")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $this->initData('index');
        return $this->get('core.index.controller_service')->generateIndexAction(NULL);
    }

    /**
     * @param Request $request
     * @Route(path="/admin/services/delete/{itemDelete}", defaults={"delete" = 0} , name="remove_service")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Request $request)
    {
        $this->initData('delete');
        $this->initData('index');
        $this->itemToTemove = $request->get('itemDelete');
        $this->get('core.service_manager')->remove($this->itemToTemove);
        return $this->get('core.delete.controller_service')->generateDeleteAction();
    }

    /**
     * @param Request $request
     * @Route(path="/admin/service/add", name="form_exec_add_service")
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
     * @Route(path="/admin/service/edit", name="form_exec_edit_service")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function form_exec_editAction(Request $request)
    {
        $this->initData('index');
        $this->formAdd = $this->generateForm();
        $this->formEdit = $this->generateForm();
        $this->formEdit->handleRequest($request);
        if ($this->formEdit->isSubmitted() && $this->formEdit->isValid()) {
            if ($request->request->get('formAction') == 'edit') {
                $this->saveEditIfSaveOrTransform($request->request->get('sendAction'), $request);
                $this->retablirOrTransformArchivedItem($request->request->get('sendaction'), $request);
                $this->get('salesforce.territory_to_service_manager')->purge($request->request->get('service')['id']);
                $this->ifSfTerritoryPresentInServiceAdd($request);
            }
        }
        return $this->get('core.index.controller_service')->getFullList(null, $this->formAdd, $this->formEdit);
    }

    /**
     * @param $serviceEdit
     * @Route(path="/ajax/service/get/{serviceEdit}",name="ajax_get_service")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function serviceGetInfosIndex($serviceEdit)
    {
        return new JsonResponse($this->get('core.service_manager')->createArray($serviceEdit));
    }
}