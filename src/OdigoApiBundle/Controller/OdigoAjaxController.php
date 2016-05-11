<?php
namespace OdigoApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Exception;

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
}