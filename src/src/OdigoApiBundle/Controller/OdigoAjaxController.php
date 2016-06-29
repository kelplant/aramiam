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
     * @param $service
     * @param $fonction
     * @Route(path="/ajax/check/odigo/isabletouse/{service}/{fonction}",name="ajax_able_use_odigo")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function isAbleToUseOdigo($service, $fonction)
    {
        if ($this->get('core.service_manager')->load($service)->getNameInOdigo() == "" || $this->get('core.fonction_manager')->load($fonction)->getNameInOdigo() == "") {
            return new JsonResponse(0);
        } else {
            return new JsonResponse(1);
        }
    }

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