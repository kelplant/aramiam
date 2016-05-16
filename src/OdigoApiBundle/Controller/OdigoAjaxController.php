<?php
namespace OdigoApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class OdigoAjaxController
 * @package OdigoApiBundle\Controller
 */
class OdigoAjaxController extends Controller
{
    /**
     * @param $utilisateurId
     * @Route(path="/ajax/odigo/get/utilisateur_infos/{utilisateurId}",name="ajax_get_odigo_utilisateur_infos")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function googleGroupGetInfosIndex($utilisateurId)
    {
        return new JsonResponse($this->get('odigo.prosodie_odigo_manager')->createArrayByUser($utilisateurId));
    }

    /**
     * @Route(path="/ajax/odigo/get/odigo_number/full_list_by_service",name="ajax_get_odigo_odigo_number_full_list_by_service")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function odigoNumberGetCountListByService()
    {
        $listNumByAgence = $this->get('odigo.odigotelliste_manager')->calculNumberOfNumeroByService();
        $listNumInUseByAgence = $this->get('odigo.odigotelliste_manager')->calculNumberOfNumeroByServiceInUse();
        return new JsonResponse($this->get('odigo.odigotelliste_manager')->calculNumberOfNumeroByService());
    }
}