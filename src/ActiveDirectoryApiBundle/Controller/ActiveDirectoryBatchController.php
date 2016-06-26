<?php
namespace ActiveDirectoryApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use GuzzleHttp;

/**
 * Class ActiveDirectoryBatchController
 * @package ActiveDirectoryApiBundle\Controller
 */
class ActiveDirectoryBatchController extends Controller
{
    private $fonctionArray;

    private $serviceArray;

    private $agenceArray;

    private $fonction;

    private $service;

    private $agence;

    /**
     * @param $toTest
     * @param $array
     * @param $setUp
     * @return string
     */
    private function ifIsInArray($toTest, $array, $setUp)
    {
        if (in_array(substr($toTest, 3), $array))
        {
            $this->$setUp = substr($toTest, 3);
        }
    }

    /**
     * @param $record
     */
    private function ifRecordDnNotemptyAndUtilisateurOU($record)
    {
        if (!is_null($record['dn']) && strpos($record['dn'], 'Utilisateurs') !== false) {
            $this->agence = null;
            $this->service = null;
            $this->fonction = null;
            $explodeDn = explode(",", $record['dn']);
            if ($explodeDn[0] != 'OU=Utilisateurs') {
                $nbCells = count($explodeDn);
                for ($i = 0; $i < $nbCells; $i++) {
                    if (substr($explodeDn[$i], 0, 3) == "OU=") {
                        $this->ifIsInArray($explodeDn[$i], $this->fonctionArray, 'fonction');
                        $this->ifIsInArray($explodeDn[$i], $this->serviceArray, 'service');
                        $this->ifIsInArray($explodeDn[$i], $this->agenceArray, 'agence');
                    }
                }
                $this->get('ad.active_directory_organisation_unit_manager')->add(array('id' => $this->get('ad.active_directory_api_user_service')->toReadableGuid($record['objectguid'][0]), 'name' => $record['name'][0], 'dn' => $record['dn'], 'agence' => $this->agence, 'service' => $this->service, 'fonction' => $this->fonction));
            }
        }
    }

    /**
     * @Route(path="/ajax/active_directory/groupe/reload",name="ajax_active_directory_profile")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function reloadActiveDirectoryGroupeTable()
    {

        $this->get('ad.active_directory_group_manager')->truncateTable();
        $response = $this->get('ad.active_directory_api_user_service')->executeQueryWithFilter($this->getParameter('active_directory'), '(objectCategory=group)', array("objectGUID", "dn", "name"));
        foreach ((array)$response as $record) {
            if (!is_null($record['dn'])) {
                $this->get('ad.active_directory_group_manager')->add(array('id' => $this->get('ad.active_directory_api_user_service')->toReadableGuid($record['objectguid'][0]), 'name' => $record['name'][0], 'dn' => $record['dn']));
            }
        }
        return $this->render("ActiveDirectoryApiBundle:Batch:succes.html.twig");
    }

    /**
     * @Route(path="/ajax/active_directory/organisations_units/reload",name="ajax_active_directory_organisations_units")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function reloadActiveDirectoryOrganisationUnitsTable()
    {
        $this->fonctionArray = $this->get('core.fonction_manager')->customSelectNameInActiveDirectoryNotNull();
        $this->serviceArray = $this->get('core.service_manager')->customSelectNameInActiveDirectoryNotNull();
        $this->agenceArray = $this->get('core.agence_manager')->customSelectNameInActiveDirectoryNotNull();
        $this->get('ad.active_directory_organisation_unit_manager')->truncateTable();
        $response = $this->get('ad.active_directory_api_user_service')->executeQueryWithFilter($this->getParameter('active_directory'), '(objectCategory=organizationalUnit)', array("objectGUID", "dn", "name"));
        foreach ((array)$response as $record) {
            $this->ifRecordDnNotemptyAndUtilisateurOU($record);
        }
        return $this->render("ActiveDirectoryApiBundle:Batch:succes.html.twig");
    }
}