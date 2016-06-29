<?php
namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

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
     * @param $serviceId
     * @param $poste
     * @Route(path="/ajax/service/poste/get/{serviceId}/{poste}",name="ajax_get_service_managers")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function serviceGetPosteInfosIndex($serviceId, $poste)
    {
        $usersList = $this->get('core.manager_service_link_manager')->getManagerForService($serviceId, $poste);
        $finalTab = [];
        foreach ($usersList as $key => $value) {
            $finalTab[$key] = $this->get('core.utilisateur_manager')->load($key)->getViewName();
        }
        return new JsonResponse($finalTab);
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
     * @param $serviceId
     * @Route(path="/ajax/service/get/service/manager/{serviceId}",name="ajax_get_service_manager")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getServiceManagerId($serviceId)
    {
        $fulllist = $this->get('core.manager_service_link_manager')->getRepository()->findBy(array('serviceId' => $serviceId));
        $finalTab = [];
        foreach ($fulllist as $item) {
            $finalTab[$item->getUserId()] = $item->getProfilType();
        }
        return new JsonResponse($finalTab);
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
     * @param string $string
     * @param $manager
     * @param $return
     */
    private function conditionalLoad($results, $i, $string, $manager, $return)
    {
        if ($results[$i][$string] != 'null' && $results[$i][$string] != null) {
            return $this->get($manager)->load($results[$i][$string])->{"get".$return}();
        }
    }

    /**
     * @param $results
     * @param integer $i
     * @param string $what
     * @param string $manager
     * @param string $return
     * @return mixed
     */
    private function ifFieldIsWhat($results, $i, $what, $manager, $return)
    {
        if ($results[$i]['field'] == $what) {
            $results[$i]['oldString'] = $this->conditionalLoad($results, $i, 'oldString', $manager, $return);
            $results[$i]['newString'] = $this->conditionalLoad($results, $i, 'newString', $manager, $return);
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
        $maxResults = count($results);
        for ($i = 0; $i < $maxResults; $i++) {
            $results   = $this->ifFieldIsWhat($results, $i, 'agence', 'core.agence_manager', 'Name');
            $results   = $this->ifFieldIsWhat($results, $i, 'service', 'core.service_manager', 'Name');
            $results   = $this->ifFieldIsWhat($results, $i, 'fonction', 'core.fonction_manager', 'Name');
            $results   = $this->ifFieldIsWhat($results, $i, 'entiteHolding', 'core.entiteHolding_manager', 'Name');
            $results   = $this->ifFieldIsWhat($results, $i, 'responsable', 'core.utilisateur_manager', 'viewName');
            $results   = $this->ifFieldIsWhat($results, $i, 'predecesseur', 'core.utilisateur_manager', 'viewName');
            $requester = $this->get('app.user_manager')->load($results[$i]['requesterId']);
            if ($requester != null) {
                $results[$i]['requesterId'] = $requester->getDisplayName();
            }
        }

        return new JsonResponse($results);
    }
}