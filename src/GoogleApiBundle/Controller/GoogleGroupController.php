<?php
namespace GoogleApiBundle\Controller;

use GoogleApiBundle\Entity\GoogleGroup;
use GoogleApiBundle\Form\GoogleGroupType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class GoogleGroupController
 * @package GoogleApiBundle\Controller
 */
class GoogleGroupController extends Controller
{
    /**
     *
     */
    private function initData($service)
    {
        $this->get('core.'.$service.'.controller_service')->setEntity('GoogleGroup');
        $this->get('core.'.$service.'.controller_service')->setNewEntity(GoogleGroup::class);
        $this->get('core.'.$service.'.controller_service')->setFormType(GoogleGroupType::class);
        $this->get('core.'.$service.'.controller_service')->setAlertText('ce groupe Gmail');
        $this->get('core.'.$service.'.controller_service')->setIsArchived(NULL);
        $this->get('core.'.$service.'.controller_service')->setCreateFormArguments(array());
        $this->get('core.'.$service.'.controller_service')->setServicePrefix('google');
    }

    /**
     * @Route(path="/app/google/groupe_liste", name="google_groupe_liste")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $this->initData('index');
        return $this->get('core.index.controller_service')->generateIndexAction(NULL);
    }

    /**
     * @param Request $request
     * @Route(path="/app/google/groupe/edit", name="form_exec_edit_google_groupe")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function form_exec_editAction(Request $request)
    {
        $this->initData('edit');
        $this->initData('index');
        return $this->get('core.edit.controller_service')->executeRequestEditAction($request);
    }

    /**
     * @param $googleGroupEdit
     * @Route(path="/ajax/google_group/get/{googleGroupEdit}",name="ajax_get_google_group")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function salesforceGroupGetInfosIndex($googleGroupEdit)
    {
        return new JsonResponse($this->get('google.google_group_manager')->createArray($googleGroupEdit));
    }
}