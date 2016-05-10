<?php
namespace SalesforceApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use GuzzleHttp;

/**
 * Class SalesforceBatchController
 * @package SalesforceApiBundle\Controller
 */
class SalesforceBatchController extends Controller
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
            $response = json_decode($this->get('salesforce.salesforce_api_user_service')->getListOfProfiles($this->getParameter('salesforce')))->records;
            foreach ((array)$response as $record) {
                $this->get('salesforce.salesforceprofile_manager')->add(array('profileId' => $record->Id, 'profileName' => $record->Name, 'userLicenseId' => $record->UserLicenseId, 'userType' => $record->UserType));
            }
            return $this->render("SalesforceApiBundle:Batch:succes.html.twig");
        } else {
            return $this->render("SalesforceApiBundle:Batch:failed.html.twig");
        }
    }

    /**
     * @Route(path="/batch/salesforce/territory/reload/{login}/{password}",name="batch_salesforce_territory")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function reloadSalesforceTerritoryTable($login, $password)
    {
        if ($this->get('app.security.acces_service')->validateUser($login, $password) === true)
        {
            $this->get('salesforce.salesforceterritory_manager')->truncateTable();
            $response = json_decode($this->get('salesforce.salesforce_api_territories_services')->getListOfTerritories($this->getParameter('salesforce')))->records;
            foreach ((array)$response as $record) {
                $this->get('salesforce.salesforceterritory_manager')->add(array('territoryId' => $record->Id, 'territoryName' => $record->Name, 'parentTerritoryId' => $record->ParentTerritoryId));
            }

            return $this->render("SalesforceApiBundle:Batch:succes.html.twig");
        } else {
            return $this->render("SalesforceApiBundle:Batch:failed.html.twig");
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
            $response = json_decode($this->get('salesforce.salesforce_api_groupes_services')->getListOfGroupes($this->getParameter('salesforce')))->records;
            foreach ((array)$response as $record) {
                $this->get('salesforce.salesforcegroupe_manager')->add(array('groupeId' => $record->Id, 'groupeName' => $record->Name));
            }
            return $this->render("SalesforceApiBundle:Batch:succes.html.twig");
        } else {
            return $this->render("SalesforceApiBundle:Batch:failed.html.twig");
        }
    }
}