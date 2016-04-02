<?php
/**
 * Created by PhpStorm.
 * User: Xavier
 * Date: 02/04/2016
 * Time: 05:57
 */

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AjaxController extends Controller
{
    /**
     * @param $candidatEdit
     * @Route(path="/ajax/candidat/get/{candidatEdit}",name="ajax_get_candidat")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getCandidatInfosIndex($candidatEdit)
    {
        return new JsonResponse($this->get('core.candidat_manager')->createArray($candidatEdit));
    }

    /**
     * @param $agenceEdit
     * @Route(path="/ajax/agence/get/{agenceEdit}",name="ajax_get_agence")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getAgenceInfosIndex($agenceEdit)
    {
        return new JsonResponse($this->get('core.agence_manager')->createArray($agenceEdit));
    }

    /**
     * @param $fonctionEdit
     * @Route(path="/ajax/fonction/get/{fonctionEdit}",name="ajax_get_fonction")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getFonctionInfosIndex($fonctionEdit)
    {
        return new JsonResponse($this->get('core.fonction_manager')->createArray($fonctionEdit));
    }

    /**
     * @param $serviceEdit
     * @Route(path="/ajax/service/get/{serviceEdit}",name="ajax_get_service")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getServiceInfosIndex($serviceEdit)
    {
        return new JsonResponse($this->get('core.service_manager')->createArray($serviceEdit));
    }
}