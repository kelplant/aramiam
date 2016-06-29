<?php
namespace ActiveDirectoryApiBundle\Controller;

use ActiveDirectoryApiBundle\Entity\ActiveDirectoryGroup;
use ActiveDirectoryApiBundle\Form\ActiveDirectoryGroupType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class ActiveDirectoryGroupController
 * @package ActiveDirectoryApiBundle\Controller
 */
class ActiveDirectoryGroupController extends Controller
{
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
     * @param $activeDirectoryGroupEdit
     * @Route(path="/ajax/active_directory_group/get/{activeDirectoryGroupEdit}",name="ajax_get_active_directory_group")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function salesforceGroupGetInfosIndex($activeDirectoryGroupEdit)
    {
        return new JsonResponse($this->get('ad.active_directory_group_manager')->createArray($activeDirectoryGroupEdit));
    }
}