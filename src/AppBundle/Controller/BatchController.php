<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use GuzzleHttp;

/**
 * Class BatchController
 * @package AppBundle\Controller
 */
class BatchController extends Controller
{
    /**
     * @Route(path="/batch/salesforce/profile/reload/{login}/{password}",name="batch_salesforce_profile")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function reloadSalesforceProfileTable($login, $password)
    {
        if ($this->get('app.security.acces_service')->validateUser($login, $password) === true)
        {
            $this->get('salesforce.salesforceprofile_manager')->truncateTable();
            $response = json_decode($this->get('salesforce.salesforce_api_service')->getListOfProfiles($this->getParameter('salesforce'))["error"])->records;
            foreach ((array)$response as $record) {
                $this->get('salesforce.salesforceprofile_manager')->add(array('profileId' => $record->Id, 'profileName' => $record->Name, 'userLicenseId' => $record->UserLicenseId, 'userType' => $record->UserType));
            }
            return $this->render("AppBundle:Batch:succes.html.twig");
        } else {
            return $this->render("AppBundle:Batch:failed.html.twig");
        }
    }

    /**
     * @Route(path="/batch/salesforce/groupe/reload/{login}/{password}",name="batch_salesforce_groupe")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function reloadSalesforceGroupeTable($login, $password)
    {
        if ($this->get('app.security.acces_service')->validateUser($login, $password) === true)
        {
            $this->get('salesforce.salesforcegroupe_manager')->truncateTable();
            $response = json_decode($this->get('salesforce.salesforce_api_service')->getListOfGroupes($this->getParameter('salesforce'))["error"])->records;
            foreach ((array)$response as $record) {
                $this->get('salesforce.salesforcegroupe_manager')->add(array('groupeId' => $record->Id, 'groupeName' => $record->Name));
            }
            return $this->render("AppBundle:Batch:succes.html.twig");
        } else {
            return $this->render("AppBundle:Batch:failed.html.twig");
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
        return new JsonResponse($this->get('odigo.odigotelliste_manager')->addFromApi($explodedTab[0][0], $this->get('core.service_manager')->returnIdFromOdigoName($explodedTab[0][1]), $this->get('core.fonction_manager')->returnIdFromOdigoName($explodedTab[0][2])));
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
        return new JsonResponse($this->get('odigo.orangetelliste_manager')->addFromApi($explodedTab[0][0], $this->get('core.service_manager')->returnIdFromOdigoName($explodedTab[0][1])));
    }

    /**

     * @Route(path="/batch/insert/agencies",name="ajax_insert_agencies")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loadAgenciesFromAramis()
    {
        $this->get('aramis.aramisagency_manager')->truncateTable();
        $client = new GuzzleHttp\Client();
        $res = $client->request('GET', $this->getParameter('aramis_api')['ws_agency_url'], [
            'headers' => [
                'Accept' => 'application/json',
                'Content-type' => 'application/json',
            ]
        ]);
        foreach(json_decode($res->getBody()) as $agence) {
            $addAgency = $this->get('aramis.factory.aramis_agency')->createFromEntity($agence);
            if (!is_null($addAgency->getId()) && $addAgency->getId() != "00") {
                $this->get('core.agence_manager')->save($addAgency);
            } else {
                $this->get('core.agence_manager')->flush();
            }
        }
        return new JsonResponse($res->getBody());
    }
}