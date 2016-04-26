<?php
namespace ActiveDirectoryApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Exception;

/**
 * Class ActiveDirectoryAjaxController
 * @package ActiveDirectoryApiBundle\Controller
 */
class ActiveDirectoryAjaxController extends Controller
{
    /**
     * @Route(path="/ajax/get/active_directory/groupes",name="ajax_get_active_directory_groupes")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getActiveDirectoryGroupeListe()
    {
        $finalTab = array();
        $i = 0;
        foreach ($this->get('ad.active_directory_group_manager')->getStandardProfileListe() as $item) {
            $finalTab[$i] = array('id' => $item->getId(), 'name' => $item->getName());
            $i++;
        }
        return new JsonResponse($finalTab);
    }

    /**
     * @param $fonctionId
     * @Route(path="/ajax/get/active_directory/group_fonction/{fonctionId}",name="ajax_get_active_directory_group_fonction")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getActiveDirectoryGroupForFonction($fonctionId)
    {
        $groupesIds = $this->get('ad.active_directory_group_match_fonction_manager')->createArray($fonctionId);
        $groupes = [];
        foreach ($groupesIds as $groupe)
        {
            $groupe = $this->get('ad.active_directory_group_manager')->load($groupe);
            $groupes[] = array('id' => $groupe->getId(), 'name' => $groupe->getName());
        }
        return new JsonResponse($groupes);
    }

    /**
     * @param $serviceId
     * @Route(path="/ajax/get/active_directory/group_service/{serviceId}",name="ajax_get_active_directory_group_service")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getActiveDirectoryGroupForServce($serviceId)
    {
        $groupesIds = $this->get('ad.active_directory_group_match_service_manager')->createArray($serviceId);
        $groupes = [];
        foreach ($groupesIds as $groupe)
        {
            $groupe = $this->get('ad.active_directory_group_manager')->load($groupe);
            $groupes[] = array('id' => $groupe->getId(), 'name' => $groupe->getName());
        }
        return new JsonResponse($groupes);
    }
}