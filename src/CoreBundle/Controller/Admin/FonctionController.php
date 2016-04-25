<?php
namespace CoreBundle\Controller\Admin;

use CoreBundle\Form\Admin\FonctionType;
use CoreBundle\Entity\Admin\Fonction;
use CoreBundle\Services\Core\AbstractControllerService;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class FonctionController
 * @package CoreBundle\Controller
 */
class FonctionController extends AbstractControllerService
{
    private $itemToTemove;

    /**
     *
     */
    private function selfInit()
    {
        $this->entity = 'Fonction';
        $this->servicePrefix = 'core';
        $this->newEntity = Fonction::class;
        $this->formType = FonctionType::class;
        $this->createFormArguments = array();
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
        $this->get('core.'.$service.'.controller_service')->setAlertText('cette fonction');
        $this->get('core.'.$service.'.controller_service')->setIsArchived(NULL);
        $this->get('core.'.$service.'.controller_service')->setCreateFormArguments($this->createFormArguments);
        $this->get('core.'.$service.'.controller_service')->setServicePrefix($this->servicePrefix);
    }

    /**
     * @param $request
     */
    private function ifSfGroupePresentInFonctionAdd($request)
    {
        if ($request->request->get('salesforce') != '') {
            $this->get('salesforce.groupe_to_fonction_manager')->deleteForFonctionId($request->request->get('fonction')['id']);
            foreach ($request->request->get('salesforce') as $key => $value) {
                if (substr($key, 0, 6) == 'groupe') {
                    $this->get('salesforce.groupe_to_fonction_manager')->add(array('salesforceGroupe' => $value, 'fonctionId' => $request->request->get('fonction')['id']));
                }
            }
        }
    }

    /**
     * @param $request
     */
    private function ifSfServiceCloudInFonctionAdd($request)
    {
        if (isset($request->request->get('salesforce')['service_cloud_acces'])) {
            $this->get('salesforce.service_cloud_acces_manager')->setFonctionAcces($request->request->get('fonction')['id'], $request->request->get('salesforce')['service_cloud_acces']);
        }
    }

    /**
     * @Route(path="/admin/fonctions", name="liste_des_fonctions")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $this->initData('index');
        return $this->get('core.index.controller_service')->generateIndexAction(NULL);
    }

    /**
     * @param Request $request
     * @Route(path="/admin/fonctions/delete/{itemDelete}", name="remove_fonction")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Request $request)
    {
        $this->initData("delete");
        $this->initData("index");
        $this->itemToTemove = $request->get('itemDelete');
        $this->get('core.fonction_manager')->remove($this->itemToTemove);
        return $this->get('core.delete.controller_service')->generateDeleteAction();
    }

    /**
     * @param Request $request
     * @Route(path="/admin/fonction/add", name="form_exec_add_fonction")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function form_exec_addAction(Request $request)
    {
        $this->initData("add");
        $this->initData("index");
        return $this->get('core.add.controller_service')->executeRequestAddAction($request);
    }

    /**
     * @param Request $request
     * @Route(path="/admin/fonction/edit", name="form_exec_edit_fonction")
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
                $this->get('salesforce.groupe_to_fonction_manager')->purge($request->request->get('fonction')['id']);
                $this->ifSfGroupePresentInFonctionAdd($request);
                $this->ifSfServiceCloudInFonctionAdd($request);
            }
        }
        return $this->get('core.index.controller_service')->getFullList(null, $this->formAdd, $this->formEdit);
    }

    /**
     * @param $fonctionEdit
     * @Route(path="/ajax/fonction/get/{fonctionEdit}",name="ajax_get_fonction")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function fonctionGetInfosIndex($fonctionEdit)
    {
        return new JsonResponse($this->get('core.fonction_manager')->createArray($fonctionEdit));
    }
}