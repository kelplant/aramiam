<?php
namespace SalesforceApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class SalesforceAjaxController
 * @package SalesforceApiBundle\Controller
 */
class SalesforceAjaxController extends Controller
{
    /**
     * @param $userMail
     * @Route(path="/ajax/get/salesforce/utilisateur/{userMail}",name="ajax_get_salesforce_utilisateur")
     * @return JsonResponse
     */
    public function getUserOnSalesforceByEmail($userMail)
    {
        return new JsonResponse(json_decode($this->get('salesforce.salesforce_api_user_service')->getAccountByUsername($userMail, $this->getParameter('salesforce'))));
    }

    /**
     * @param $userId
     * @Route(path="/ajax/get/salesforce/utilisateur_group/{userId}",name="ajax_get_salesforce_utilisateur_group")
     * @return JsonResponse
     */
    public function getListOfGroupesForUser($userId)
    {
        $userInfos = $this->get('core.utilisateur_manager')->load($userId);
        $listFromSalesforce = json_decode($this->get('salesforce.salesforce_api_groupes_services')->getListOfGroupesForUser($this->getParameter('salesforce'), $userInfos->getIsCreateInSalesforce()));
        if (is_array($listFromSalesforce) == true) {
            return new JsonResponse(null);
        } else if ($listFromSalesforce->totalSize != 0) {
            $finalTab = [];
            foreach ($listFromSalesforce->records as $groupe) {
                $finalgroup = $this->get('salesforce.salesforcegroupe_manager')->load($groupe->GroupId);
                $finalTab[] = $finalgroup->getGroupeName();
            }
            return new JsonResponse($finalTab);
        } else {
            return new JsonResponse(null);
        }
    }

    /**
     * @param $userId
     * @Route(path="/ajax/get/salesforce/utilisateur_territories/{userId}",name="ajax_get_salesforce_utilisateur_territories")
     * @return JsonResponse
     */
    public function getListOfTerritoriesForUser($userId)
    {
        $userInfos = $this->get('core.utilisateur_manager')->load($userId);
        $listFromSalesforce = json_decode($this->get('salesforce.salesforce_api_territories_services')->getListOfTerritoriesForUser($this->getParameter('salesforce'), $userInfos->getIsCreateInSalesforce()));
        if ($listFromSalesforce->totalSize != 0) {
            $finalTab = [];
            foreach ($listFromSalesforce->records as $territory) {
                $finalgroup = $this->get('salesforce.salesforceterritory_manager')->load($territory->TerritoryId);
                $finalTab[] = $finalgroup->getTerritoryName();
            }
            return new JsonResponse($finalTab);
        } else {
            return new JsonResponse(null);
        }
    }

    /**
     * @param $userMail
     * @Route(path="/ajax/get/salesforce/utilisateur/full_profil/{userMail}",name="ajax_get_salesforce_utilisateur_full_profil")
     * @return JsonResponse
     */
    public function getAllInfosForUserOnSalesforceByEmail($userMail)
    {
        return new JsonResponse(json_decode($this->get('salesforce.salesforce_api_user_service')->getAllInfosForAccountByUsername($userMail, $this->getParameter('salesforce'))));
    }
    /**
     * @Route(path="/ajax/get/salesforce/profiles",name="ajax_get_salesforce_profiles")
     * @return JsonResponse
     */
    public function getSalesforceProfilesListe()
    {
        $finalTab = array();
        $i = 0;
        foreach ($this->get('salesforce.salesforceprofile_manager')->getStandardProfileListe() as $item) {
            $finalTab[$i] = array('id' => $item->getId(), 'profileId' => $item->getProfileId(), 'profileName' => $item->getProfileName(), 'userLicenseId' => $item->getUserLicenseId(), 'userType' => $item->getUserType());
            $i++;
        }
        return new JsonResponse($finalTab);
    }

    /**
     * @Route(path="/ajax/get/salesforce/territories",name="ajax_get_salesforce_territories")
     * @return JsonResponse
     */
    public function getSalesforceTerritoryListe()
    {
        $finalTab = array();
        $i = 0;
        foreach ($this->get('salesforce.salesforceterritory_manager')->getStandardTerritoriesListe() as $item) {
            $finalTab[$i] = array('id' => $item->getId(), 'territoryId' => $item->getTerritoryId(), 'territoryName' => $item->getTerritoryName(), 'parentTerritoryId' => $item->getParentTerritoryId());
            $i++;
        }
        return new JsonResponse($finalTab);
    }

    /**
     * @Route(path="/ajax/get/salesforce/groupes",name="ajax_get_salesforce_groupes")
     * @return JsonResponse
     */
    public function getSalesforceGroupeListe()
    {
        $finalTab = array();
        $i = 0;
        foreach ($this->get('salesforce.salesforcegroupe_manager')->getStandardProfileListe() as $item) {
            $finalTab[$i] = array('id' => $item->getId(), 'groupeId' => $item->getGroupeId(), 'groupeName' => $item->getGroupeName());
            $i++;
        }
        return new JsonResponse($finalTab);
    }

    /**
     * @param $fonctionId
     * @Route(path="/ajax/get/salesforce/service_cloud/{fonctionId}",name="ajax_get_salesforce_service_cloud")
     * @return JsonResponse
     */
    public function getSalesforceServiceCloudForFonction($fonctionId)
    {
        return new JsonResponse($this->get('salesforce.service_cloud_acces_manager')->createArray($fonctionId));
    }

    /**
     * @param $fonctionId
     * @Route(path="/ajax/get/salesforce/groupe_fonction/{fonctionId}",name="ajax_get_salesforce_groupe_fonction")
     * @return JsonResponse
     */
    public function getSalesforceGroupeForFonction($fonctionId)
    {
        $groupesIds = $this->get('salesforce.groupe_to_fonction_manager')->createArray($fonctionId);
        $groupes = [];
        foreach ($groupesIds as $groupe) {
            $groupe = $this->get('salesforce.salesforcegroupe_manager')->load($groupe);
            $groupes[] = array('id' => $groupe->getId(), 'groupeName' => $groupe->getGroupeName());
        }
        return new JsonResponse($groupes);
    }

    /**
     * @param $serviceId
     * @Route(path="/ajax/get/salesforce/territory_service/{serviceId}",name="ajax_get_salesforce_territory_service")
     * @return JsonResponse
     */
    public function getSalesforceTerritoryForService($serviceId)
    {
        $territoriesIds = $this->get('salesforce.territory_to_service_manager')->createArray($serviceId);
        $territories = [];
        foreach ($territoriesIds as $territory) {
            $territory = $this->get('salesforce.salesforceterritory_manager')->load($territory);
            $territories[] = array('id' => $territory->getId(), 'territoryName' => $territory->getTerritoryName());
        }
        return new JsonResponse($territories);
    }
}