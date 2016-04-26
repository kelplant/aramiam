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
     * @param $hashAndCryptedSid
     * @return string
     */
    private function transcodeSid($hashAndCryptedSid)
    {
        $sidinhex = str_split(bin2hex($hashAndCryptedSid), 2);
        $sid = 'S-'.hexdec($sidinhex[0])."-".hexdec($sidinhex[6].$sidinhex[5].$sidinhex[4].$sidinhex[3].$sidinhex[2].$sidinhex[1]);
        $subauths = hexdec($sidinhex[7]);
        for ($i = 0; $i < $subauths; $i++) {
            $start = 8 + (4 * $i);
            $sid = $sid."-".hexdec($sidinhex[$start + 3].$sidinhex[$start + 2].$sidinhex[$start + 1].$sidinhex[$start]);
        }
        return $sid;
    }


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
            $nbCells = count($explodeDn);
            for ($i = 0; $i < $nbCells; $i++) {
                if (substr($explodeDn[$i], 0, 3) == "OU=") {
                    $this->ifIsInArray($explodeDn[$i], $this->fonctionArray, 'fonction');
                    $this->ifIsInArray($explodeDn[$i], $this->serviceArray, 'service');
                    $this->ifIsInArray($explodeDn[$i], $this->agenceArray, 'agence');
                }
            }
            $this->get('ad.active_directory_organisation_unit_manager')->add(array('id' => $this->_to_p_guid($record['objectguid'][0]), 'name' => $record['name'][0], 'dn' => $record['dn'], 'agence' => $this->agence, 'service' => $this->service, 'fonction' => $this->fonction));
        }
    }

    /**
     * @Route(path="/batch/active_directory/groupe/reload/{login}/{password}",name="batch_active_directory_profile")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function reloadActiveDirectoryGroupeTable($login, $password)
    {
        if ($this->get('app.security.acces_service')->validateUser($login, $password) === true)
        {
            $this->get('ad.active_directory_group_manager')->truncateTable();
            $response = $this->get('ad.active_directory_api_service')->executeQueryWithFilter($this->getParameter('active_directory'), '(objectCategory=group)', array("objectGUID", "dn", "name"));
            foreach ((array)$response as $record) {
                if (!is_null($record['dn'])) {
                    $this->get('ad.active_directory_group_manager')->add(array('id' => $this->get('ad.active_directory_api_service')->_to_p_guid($record['objectguid'][0]), 'name' => $record['name'][0], 'dn' => $record['dn']));
                }
            }
            return $this->render("ActiveDirectoryApiBundle:Batch:succes.html.twig");
        } else {
            return $this->render("ActiveDirectoryApiBundle:Batch:failed.html.twig");
        }
    }

    /**
     * @Route(path="/batch/active_directory/organisations_units/reload/{login}/{password}",name="batch_active_directory_organisations_units")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function reloadActiveDirectoryOrganisationUnitsTable($login, $password)
    {
        if ($this->get('app.security.acces_service')->validateUser($login, $password) === true)
        {
            $this->fonctionArray = $this->get('core.fonction_manager')->customSelectNameInActiveDirectoryNotNull();
            $this->serviceArray = $this->get('core.service_manager')->customSelectNameInActiveDirectoryNotNull();
            $this->agenceArray = $this->get('core.agence_manager')->customSelectNameInActiveDirectoryNotNull();
            $this->get('ad.active_directory_organisation_unit_manager')->truncateTable();
            $response = $this->get('ad.active_directory_api_service')->executeQueryWithFilter($this->getParameter('active_directory'), '(objectCategory=organizationalUnit)', array("objectGUID", "dn", "name"));
            foreach ((array)$response as $record) {
                $this->ifRecordDnNotemptyAndUtilisateurOU($record);
            }
            return $this->render("ActiveDirectoryApiBundle:Batch:succes.html.twig");
        } else {
            return $this->render("ActiveDirectoryApiBundle:Batch:failed.html.twig");
        }
    }
}