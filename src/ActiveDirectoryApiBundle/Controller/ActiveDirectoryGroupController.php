<?php
namespace ActiveDirectoryApiBundle\Controller;

use ActiveDirectoryApiBundle\Entity\ActiveDirectoryGroup;
use ActiveDirectoryApiBundle\Form\ActiveDirectoryGroupType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class ActiveDirectoryGroupController
 * @package ActiveDirectoryApiBundle\Controller
 */
class ActiveDirectoryGroupController extends Controller
{
    private $itemToTemove;

    /**
     *
     */
    private function initData($service)
    {
        $this->get('core.'.$service.'.controller_service')->setEntity('ActiveDirectoryGroup');
        $this->get('core.'.$service.'.controller_service')->setNewEntity(ActiveDirectoryGroup::class);
        $this->get('core.'.$service.'.controller_service')->setFormType(ActiveDirectoryGroupType::class);
        $this->get('core.'.$service.'.controller_service')->setAlertText('ce groupe Active Directory');
        $this->get('core.'.$service.'.controller_service')->setIsArchived(NULL);
        $this->get('core.'.$service.'.controller_service')->setCreateFormArguments(array());
        $this->get('core.'.$service.'.controller_service')->setServicePrefix('ad');
    }

    /**
     * @Route(path="/app/active_directory/groupe_liste", name="active_directory_groupe_liste")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $this->initData('index');
        return $this->get('core.index.controller_service')->generateIndexAction(NULL);
    }

    /**
     * @param Request $request
     * @Route(path="/app/active_directory/groupe/delete/{itemDelete}", defaults={"delete" = 0} , name="remove_active_directorygroupe")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Request $request)
    {
        $this->initData('delete');
        $this->initData('index');
        $this->itemToTemove = $request->get('itemDelete');
        $this->get('ad.active_directory_group_manager')->remove($this->itemToTemove);
        return $this->get('core.delete.controller_service')->generateDeleteAction();
    }

    /**
     * @param Request $request
     * @Route(path="/app/active_directory/groupe/add", name="form_exec_add_active_directory_groupe")
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
     * @Route(path="/app/active_directory/sgroupe/edit", name="form_exec_edit_active_directory_groupe")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function form_exec_editAction(Request $request)
    {
        $this->initData('edit');
        $this->initData('index');
        return $this->get('core.edit.controller_service')->executeRequestEditAction($request);
    }
}