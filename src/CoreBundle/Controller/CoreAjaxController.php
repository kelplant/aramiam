<?php
namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Exception;

/**
 * Class CoreAjaxController
 * @package CoreBundle\Controller
 */
class CoreAjaxController extends Controller
{
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
     * @param $candidatEdit
     * @Route(path="/ajax/candidat/get/{candidatEdit}",name="ajax_get_candidat")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function candidatGetInfosIndex($candidatEdit)
    {
        return new JsonResponse($this->get('core.candidat_manager')->createArray($candidatEdit));
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
     * @param $fonctionEdit
     * @Route(path="/ajax/fonction/get/{fonctionEdit}",name="ajax_get_fonction")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function fonctionGetInfosIndex($fonctionEdit)
    {
        return new JsonResponse($this->get('core.fonction_manager')->createArray($fonctionEdit));
    }

    /**
     * @Route(path="/ajax/fonction/load/full_liste",name="ajax_load_core_foncton_full_liste")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function coreFonctionGetInfosIndex()
    {
        return new JsonResponse($this->get('core.fonction_manager')->getStandardFonctionListe());
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
     * @Route(path="/ajax/service/load/full_liste",name="ajax_load_service_full_liste")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function serviceGetFullListe()
    {
        return new JsonResponse($this->get('core.service_manager')->getStandardServiceListe());
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
     * @param $results
     * @param $i
     * @param $what
     * @return mixed
     */
    private function ifFieldIsWhat($results, $i, $what, $manager, $return)
    {
        if($results[$i]['field'] == $what) {
            if($results[$i]['oldString'] != 'null' && $results[$i]['oldString'] != null) {
                $results[$i]['oldString'] = $this->get($manager)->load($results[$i]['oldString'])->{"get".$return}();
            }
            if($results[$i]['newString'] != 'null' && $results[$i]['newString'] != null) {
                $results[$i]['newString'] = $this->get($manager)->load($results[$i]['newString'])->{"get".$return}();
            }
        }

        return $results;
    }

    /**
     * @param $utilisateurId
     * @Route(path="/ajax/generate/utilisateur/history/{utilisateurId}",name="ajax_generate_utilisateur_history")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function generateHistoriqueforuser($utilisateurId)
    {
        $results = $this->get('core.utilisateur_log_action_manager')->getHistoryforUtilisateur($utilisateurId);

        for($i = 0; $i < count($results); $i++) {
            $results = $this->ifFieldIsWhat($results, $i, 'agence', 'core.agence_manager', 'Name');
            $results = $this->ifFieldIsWhat($results, $i, 'service', 'core.service_manager', 'Name');
            $results = $this->ifFieldIsWhat($results, $i, 'fonction', 'core.fonction_manager', 'Name');
            $results = $this->ifFieldIsWhat($results, $i, 'entiteHolding', 'core.entiteHolding_manager', 'Name');
            $results = $this->ifFieldIsWhat($results, $i, 'responsable', 'core.utilisateur_manager', 'viewName');
            $results = $this->ifFieldIsWhat($results, $i, 'predecesseur', 'core.utilisateur_manager', 'viewName');
            $results[$i]['requesterId'] = $this->get('app.user_manager')->load($results[$i]['requesterId'])->getDisplayName();
        }

        return new JsonResponse($results);
    }
}