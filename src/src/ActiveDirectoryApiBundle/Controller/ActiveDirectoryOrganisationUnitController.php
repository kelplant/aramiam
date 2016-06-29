<?php
namespace ActiveDirectoryApiBundle\Controller;

use ActiveDirectoryApiBundle\Entity\ActiveDirectoryOrganisationUnit;
use ActiveDirectoryApiBundle\Form\ActiveDirectoryOrganisationUnitType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class ActiveDirectoryGroupController
 * @package ActiveDirectoryApiBundle\Controller
 */
class ActiveDirectoryOrganisationUnitController extends Controller
{
    /**
     *
     */
    private function initData($service)
    {
        $this->get('core.'.$service.'.controller_service')->setEntity('ActiveDirectoryOrganisationUnit');
        $this->get('core.'.$service.'.controller_service')->setNewEntity(ActiveDirectoryOrganisationUnit::class);
        $this->get('core.'.$service.'.controller_service')->setFormType(ActiveDirectoryOrganisationUnitType::class);
        $this->get('core.'.$service.'.controller_service')->setAlertText('cette unité d\'organisation Active Directory');
        $this->get('core.'.$service.'.controller_service')->setIsArchived(NULL);
        $this->get('core.'.$service.'.controller_service')->setCreateFormArguments(array());
        $this->get('core.'.$service.'.controller_service')->setServicePrefix('ad');
    }

    /**
     * @Route(path="/app/active_directory/organisation_unit_liste", name="active_directory_organisation_unit_liste")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $this->initData('index');
        return $this->get('core.index.controller_service')->generateIndexAction(NULL);
    }

    /**
     * @param $actDirOrgaUnitEdit
     * @Route(path="/ajax/active_directory_organisation_unit/get/{actDirOrgaUnitEdit}",name="ajax_get_active_directory_organisation_unit")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function salesforceGroupGetInfosIndex($actDirOrgaUnitEdit)
    {
        return new JsonResponse($this->get('ad.active_directory_organisation_unit_manager')->createArray($actDirOrgaUnitEdit));
    }
}