<?php
namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class BatchController
 * @package CoreBundle\Controller
 */
class BatchController extends Controller
{
    /**
     * @Route(path="/batch/salesforce/{login}/{password}",name="batch_salesforce")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function reloadSalesforceProfileTable($login, $password)
    {
        if ($this->get('security.acces_service')->validateUser($login, $password) === true)
        {
            $this->get('core.salesforceprofile_manager')->truncateTable();
            $response = $this->get('core.salesforce_api_service')->getListOfProfiles($this->getParameter('salesforce'));
            foreach ((array) $response['records'] as $record) {
                $this->get('core.salesforceprofile_manager')->add(array('profileId' => $record['Id'], 'profileName' => $record['Name'], 'userLicenseId' => $record['UserLicenseId'], 'userType' => $record['UserType']));
            }
            return $this->render("@Core/Default/Batch/succes.html.twig");
        } else {
            return $this->render("@Core/Default/Batch/failed.html.twig");
        }
    }
}