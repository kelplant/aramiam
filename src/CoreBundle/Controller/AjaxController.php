<?php
namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class AjaxController
 * @package CoreBundle\Controller
 */
class AjaxController extends Controller
{
    /**
     * @param $candidatEdit
     * @Route(path="/ajax/candidat/get/{candidatEdit}",name="ajax_get_candidat")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function candidatGetInfosIndex($candidatEdit)
    {
        return new JsonResponse($this->get('core.candidat_manager')->createArray($candidatEdit));
    }

    /**
     * @param $agenceEdit
     * @Route(path="/ajax/agence/get/{agenceEdit}",name="ajax_get_agence")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function agenceGetInfosIndex($agenceEdit)
    {
        return new JsonResponse($this->get('core.agence_manager')->createArray($agenceEdit));
    }

    /**
     * @param $fonctionEdit
     * @Route(path="/ajax/fonction/get/{fonctionEdit}",name="ajax_get_fonction")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function fonctionGetInfosIndex($fonctionEdit)
    {
        return new JsonResponse($this->get('core.fonction_manager')->createArray($fonctionEdit));
    }

    /**
     * @param $serviceEdit
     * @Route(path="/ajax/service/get/{serviceEdit}",name="ajax_get_service")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function serviceGetInfosIndex($serviceEdit)
    {
        return new JsonResponse($this->get('core.service_manager')->createArray($serviceEdit));
    }

    /**
     * @param $entiteHoldingEdit
     * @Route(path="/ajax/entite_holding/get/{entiteHoldingEdit}",name="ajax_get_entite_holding")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function entiteHoldingGetInfosIndex($entiteHoldingEdit)
    {
        return new JsonResponse($this->get('core.entite_holding_manager')->createArray($entiteHoldingEdit));
    }

    /**
     * @param $utilisateurEdit
     * @Route(path="/ajax/utilisateur/get/{utilisateurEdit}",name="ajax_get_utilisateur")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function utilisateurGetInfosIndex($utilisateurEdit)
    {
        return new JsonResponse($this->get('core.utilisateur_manager')->createArray($utilisateurEdit));
    }

    /**
     * @param $utilisateurId
     * @Route(path="/ajax/generate/email/{utilisateurId}",name="ajax_generate_email")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function generateListPossibleEmailIndex($utilisateurId)
    {
        return new JsonResponse($this->get('core.utilisateur_manager')->generateListPossibleEmail($utilisateurId));
    }

    /**
     * @param $service
     * @param $fonction
     * @Route(path="/ajax/generate/odigo/{service}/{fonction}",name="ajax_generate_odigo")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function generateListPossibleTelOdigoIndex($service, $fonction)
    {
        return new JsonResponse($this->get('core.app.odigo.num_tel_liste_manager')->getAllTelForServiceAndFonction($service, $fonction));
    }

    /**
     * @param $service
     * @Route(path="/ajax/generate/orange/{service}",name="ajax_generate_orange")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function generateListPossibleTelOrangeIndex($service)
    {
        return new JsonResponse($this->get('core.app.orange.num_tel_liste_manager')->getAllTelForService($service));
    }

    /**
     * @param $service
     * @param $fonction
     * @Route(path="/ajax/generate/odigo/isabletouse/{service}/{fonction}",name="ajax_able_use_odigo")
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
}