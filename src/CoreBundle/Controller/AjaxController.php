<?php
namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Exception;

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
     * @param $odigotellisteEdit
     * @Route(path="/ajax/odigo_tel_liste/get/{odigotellisteEdit}",name="ajax_get_odigotelliste")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function odigoTelListeGetInfosIndex($odigotellisteEdit)
    {
        return new JsonResponse($this->get('core.odigotelliste_manager')->createArray($odigotellisteEdit));
    }

    /**
     * @param $orangetellisteEdit
     * @Route(path="/ajax/orange_tel_liste/get/{orangetellisteEdit}",name="ajax_get_orangetelliste")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function orangeTelListeGetInfosIndex($orangetellisteEdit)
    {
        return new JsonResponse($this->get('core.orangetelliste_manager')->createArray($orangetellisteEdit));
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
        return new JsonResponse($this->get('core.odigotelliste_manager')->getAllTelForServiceAndFonction($service, $fonction));
    }

    /**
     * @param $service
     * @Route(path="/ajax/generate/orange/{service}",name="ajax_generate_orange")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function generateListPossibleTelOrangeIndex($service)
    {
        return new JsonResponse($this->get('core.orangetelliste_manager')->getAllTelForService($service));
    }

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
     * @param $email
     * @Route(path="/ajax/check/google/isexist/{email}",name="ajax_exist_in_google")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function isExistGmailAccount($email)
    {
        try {
            return new JsonResponse($this->get('core.google_api_service')->getInfosFromEmail($this->get('core.google_api_service')->innitApi(), $email));
        } catch (Exception $e) {
            return new JsonResponse('nouser');
        }
    }

    /**
     * @param $lineToInsert
     * @Route(path="/ajax/insert/odigo/{lineToInsert}",name="ajax_insert_odigo_number")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addOdigoNumberViaFiles($lineToInsert)
    {
        $explodedTab = array();
        $explodedTab[] = explode(";", $lineToInsert);
        return new JsonResponse($this->get('core.odigotelliste_manager')->addFromApi($explodedTab[0][0], $this->get('core.service_manager')->returnIdFromOdigoName($explodedTab[0][1]), $this->get('core.fonction_manager')->returnIdFromOdigoName($explodedTab[0][2])));
    }

    /**
     * @param $lineToInsert
     * @Route(path="/ajax/insert/orange/{lineToInsert}",name="ajax_insert_orange_number")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addOrangeNumberViaFiles($lineToInsert)
    {
        $explodedTab = array();
        $explodedTab[] = explode(";", $lineToInsert);
        return new JsonResponse($this->get('core.orangetelliste_manager')->addFromApi($explodedTab[0][0], $this->get('core.service_manager')->returnIdFromOdigoName($explodedTab[0][1])));
    }
}