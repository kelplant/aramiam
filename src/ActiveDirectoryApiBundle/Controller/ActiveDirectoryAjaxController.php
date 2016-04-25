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
}