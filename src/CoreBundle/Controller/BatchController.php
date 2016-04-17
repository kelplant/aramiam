<?php
namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class BatchController
 * @package CoreBundle\Controller
 */
class BatchController extends Controller
{
    /**
     * @Route(path="/batch/salesforce/profile/reload/{login}/{password}",name="batch_salesforce_profile")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function reloadSalesforceProfileTable($login, $password)
    {
        if ($this->get('security.acces_service')->validateUser($login, $password) === true)
        {
            $this->get('core.salesforceprofile_manager')->truncateTable();
            $response = $this->get('core.salesforce_api_service')->getListOfProfiles($this->getParameter('salesforce'));
            foreach ((array)$response['records'] as $record) {
                $this->get('core.salesforceprofile_manager')->add(array('profileId' => $record['Id'], 'profileName' => $record['Name'], 'userLicenseId' => $record['UserLicenseId'], 'userType' => $record['UserType']));
            }
            return $this->render("@Core/Default/Batch/succes.html.twig");
        } else {
            return $this->render("@Core/Default/Batch/failed.html.twig");
        }
    }

    /**
     * @Route(path="/batch/salesforce/groupe/reload/{login}/{password}",name="batch_salesforce_groupe")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function reloadSalesforceGroupeTable($login, $password)
    {
        if ($this->get('security.acces_service')->validateUser($login, $password) === true)
        {
            $this->get('core.salesforcegroupe_manager')->truncateTable();
            $response = $this->get('core.salesforce_api_service')->getListOfGroupes($this->getParameter('salesforce'));
            foreach ((array)$response['records'] as $record) {
                $this->get('core.salesforcegroupe_manager')->add(array('groupeId' => $record['Id'], 'groupeName' => $record['Name']));
            }
            return $this->render("@Core/Default/Batch/succes.html.twig");
        } else {
            return $this->render("@Core/Default/Batch/failed.html.twig");
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