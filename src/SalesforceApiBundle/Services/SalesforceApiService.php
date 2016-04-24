<?php
namespace SalesforceApiBundle\Services;

use SalesforceApiBundle\Entity\SalesforceServiceCloudAcces;
use SalesforceApiBundle\Factory\SalesforceUserFactory;
use CoreBundle\Services\Manager\Admin\AgenceManager;
use CoreBundle\Services\Manager\Admin\FonctionManager;
use CoreBundle\Services\Manager\Admin\ServiceManager;
use AramisApiBundle\Services\Manager\AramisAgencyManager;
use OdigoApiBundle\Services\Manager\ProsodieOdigoManager;
use AppBundle\Services\Manager\ParametersManager;
use Symfony\Component\Config\Definition\Exception\Exception;
use SalesforceApiBundle\Services\Manager\SalesforceTokenStoreManager as SalesforceTokenStore;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SalesforceApiService
 * @package SalesforceApiBundle\Services
 */
class SalesforceApiService
{
    protected $tokenManager;

    protected $securityContext;

    protected $salesforceUserFactory;

    protected $prosodieOdigo;

    protected $agenceManager;

    protected $serviceManager;

    protected $fonctionManager;

    protected $parametersManager;

    protected $aramisAgencyManager;

    protected $serviceCloudAccesManager;

    /**
     * SalesforceApiService constructor.
     * @param SalesforceTokenStore $tokenManager
     * @param SalesforceUserFactory $salesforceUserFactory
     * @param ProsodieOdigoManager $prosodieOdigo
     * @param AgenceManager $agenceManager
     * @param ServiceManager $serviceManager
     * @param FonctionManager $fonctionManager
     * @param ParametersManager $parametersManager
     * @param AramisAgencyManager $aramisAgencyManager
     * @param SalesforceServiceCloudAcces $serviceCloudAccesManager
     */
    public function __construct($tokenManager, $securityContext, $salesforceUserFactory, $prosodieOdigo, $agenceManager, $serviceManager, $fonctionManager, $parametersManager, $aramisAgencyManager, $serviceCloudAccesManager)
    {
        $this->tokenManager = $tokenManager;
        $this->securityContext = $securityContext;
        $this->salesforceUserFactory = $salesforceUserFactory;
        $this->prosodieOdigo = $prosodieOdigo;
        $this->agenceManager = $agenceManager;
        $this->serviceManager = $serviceManager;
        $this->fonctionManager = $fonctionManager;
        $this->parametersManager = $parametersManager;
        $this->aramisAgencyManager = $aramisAgencyManager;
        $this->serviceCloudAccesManager = $serviceCloudAccesManager;
    }

    /**
     * @param string $url
     * @return resource
     */
    private function curlInitAndHeader($url)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        return $curl;
    }

    /**
     * @param $params
     * @return bool|int
     */
    private function connnect($params)
    {
        $paramsCurl = "grant_type=password"
            . "&client_id=".$params['consumerKey']
            . "&client_secret=".$params['secret']
            . "&username=".$params['username']
            . "&password=".$params['password'];
        $curl = $this->curlInitAndHeader($params['urlAauth2']);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $paramsCurl);
        $jsonDecoded = json_decode(curl_exec($curl));

        $this->tokenManager->updateOrAdd(array('username' => $this->securityContext->getToken()->getUser()->getUsername(), 'access_token' => $jsonDecoded->access_token, 'instance_url' => $jsonDecoded->instance_url, 'issued_at' => $jsonDecoded->issued_at));
        return $this->tokenManager->updateOrAdd(array('username' => $this->securityContext->getToken()->getUser()->getUsername(), 'access_token' => $jsonDecoded->access_token, 'instance_url' => $jsonDecoded->instance_url, 'issued_at' => $jsonDecoded->issued_at));
    }

    /**
     * @param $query
     * @param $params
     * @param $json
     * @param $action
     * @return array
     */
    private function initExcecuteQuery($query, $params, $json, $action)
    {
        if (is_null($this->tokenManager->loadByUsername($this->securityContext->getToken()->getUser()->getUsername()))) {
            $this->connnect($params);
        }
        $tokenInfos = $this->tokenManager->loadByUsername($this->securityContext->getToken()->getUser()->getUsername());
        $url = $tokenInfos->getInstanceUrl().'/services/data/v36.0'.$query;
        $curl = $this->curlInitAndHeader($url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $action);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: OAuth '.$tokenInfos->getAccessToken(),
            "Content-type: application/json"));
        return array('error' => curl_exec($curl), 'errorCode' => curl_getinfo($curl, CURLINFO_HTTP_CODE));
    }

    /**
     * @param $query
     * @param $params
     * @param $json
     * @param $action
     * @return array|string
     */
    public function executeQuery($query, $params, $json, $action)
    {
        try {
            $queryResult = $this->initExcecuteQuery($query, $params, $json, $action);
            return $queryResult;
        } catch (Exception $e) {
            $this->serviceManager->appendSessionMessaging(array('errorCode' => error_log($e->getMessage()), 'message' => $e->getMessage()));
            if (isset($queryResult['errorCode']) && $queryResult['errorCode'] == '200') {
                return $queryResult;
            }
            if (isset($queryResult["error"]) && json_decode($queryResult["error"])[0]->message == "Session expired or invalid") {
                $this->connnect($params);
                try {
                    return $this->initExcecuteQuery($query, $params, $json, $action);
                } catch (Exception $e) {
                    $this->serviceManager->appendSessionMessaging(array('errorCode' => error_log($e->getMessage()), 'message' => $e->getMessage()));
                }
            }
        }
    }

    /**
     * @param $params
     * @param $newSalesforceUser
     * @return array|string
     */
    public function createNewUser($params, $newSalesforceUser)
    {
        return $this->executeQuery('/sobjects/User/', $params, $newSalesforceUser, "POST");
    }

    /**
     * @param $params
     * @return mixed
     */
    public function getListOfProfiles($params)
    {
        $query = "SELECT Id,Name,UserLicenseId,UserType FROM Profile ORDER BY Name ASC NULLS LAST";
        return $this->executeQuery('/query?q='.urlencode($query), $params, null, "GET");
    }

    /**
     * @param $params
     * @return mixed
     */
    public function getListOfTerritories($params)
    {
        $query = "SELECT Id,Name,ParentTerritoryId FROM Territory ORDER BY Name ASC NULLS LAST";
        return $this->executeQuery('/query?q='.urlencode($query), $params, null, "GET");
    }

    /**
     * @param $params
     * @return mixed
     */
    public function getListOfGroupes($params)
    {
        $query = "SELECT Id,Name FROM Group ORDER BY Name ASC NULLS LAST";
        return $this->executeQuery('/query?q='.urlencode($query), $params, null, "GET");
    }

    /**
     * @param $emailToLook
     * @param $params
     * @return mixed
     */
    public function getAccountByUsername($emailToLook, $params)
    {
        $query = "SELECT Id,Username,CallCenterId FROM User WHERE Username = '".$emailToLook."'";
        return $this->executeQuery('/query?q='.urlencode($query), $params, null, "GET");
    }

    /**
     * @param $lastName
     * @param $firstName
     * @return string
     */
    private function shortNickName($lastName, $firstName)
    {
        return iconv('utf-8', 'ascii//TRANSLIT', strtolower(substr($firstName, 0, 3).str_replace(" ", "", str_replace("-", "", $lastName))));
    }

    /**
     * @param $isCreatedInOdigo
     * @param $callCenterId
     * @return array
     */
    private function ifOdigoCreated($isCreatedInOdigo, $callCenterId)
    {
        if ($isCreatedInOdigo != 0) {
            $odigoInfos = $this->prosodieOdigo->load($isCreatedInOdigo);

            return array('callcenterId' => "04va0000000TR5QAAW", 'odigoExtension' => $odigoInfos->getOdigoExtension(), 'odigoPhoneNumber' => $odigoInfos->getOdigoPhoneNumber(), 'redirectPhoneNumber' => $odigoInfos->getRedirectPhoneNumber(), 'callCenterId' => $callCenterId);
        } else {
            return array('callcenterId' => null, 'odigoExtension' => null, 'odigoPhoneNumber' => null, 'redirectPhoneNumber' => null, 'callCenterId' => null);
        }
    }

    /**
     * @param $sendaction
     * @param $isCreateInSalesforce
     * @param Request $request
     * @param $params
     * @return array|null|string
     */
    public function ifSalesforceCreate($sendaction, $isCreateInSalesforce, Request $request, $params)
    {
        if ($sendaction == "Créer sur Salesforce" && $isCreateInSalesforce == 0) {
            $paramsForSalesforceApi = $this->parametersManager->getAllAppParams('salesforce_api');
            $nickname = $this->shortNickName($request->request->get('utilisateur')['name'], $request->request->get('utilisateur')['surname']);
            $odigoInfos = $this->ifOdigoCreated($request->request->get('utilisateur')['isCreateInOdigo'],  $paramsForSalesforceApi["salesforce_odigo_cti_id"]);
            $agenceCompany = $this->aramisAgencyManager->load($this->agenceManager->load($request->request->get('utilisateur')['agence'])->getNameInCompany());
            $newSalesforceUser = $this->salesforceUserFactory->createFromEntity(
                array(
                    'Username' => $request->request->get('utilisateur')['email'],
                    'LastName' => $request->request->get('utilisateur')['name'],
                    'FirstName' => $request->request->get('utilisateur')['surname'],
                    'Email' => $request->request->get('utilisateur')['email'],
                    'TimeZoneSidKey' => 'Europe/Paris',
                    'Alias' => substr($nickname, 0, 8),
                    'CommunityNickname' => $nickname."aramisauto",
                    'IsActive' => true,
                    'LocaleSidKey' => "fr_FR",
                    'EmailEncodingKey' => "ISO-8859-1",
                    'ProfileId' => $request->request->get('salesforce')['profile'],
                    'LanguageLocaleKey' => "FR",
                    'UserPermissionsMobileUser' => true,
                    'UserPreferencesDisableAutoSubForFeeds' => false,
                    'CallCenterId' => $odigoInfos['callCenterId'],
                    'Street' => $agenceCompany->getAddress1(),
                    'City' => $agenceCompany->getCity(),
                    'PostalCode' => $agenceCompany->getZipCode(),
                    'State ' => 'France',
                    'ExternalID__c' => '9999', #Id from Robusto
                    'Fax' => '0606060606', //Fax from Robusto Agence
                    'Extension' => $odigoInfos['odigoExtension'],
                    'OdigoCti__Odigo_login__c' => $odigoInfos['odigoExtension'],
                    'Telephone_interne__c' => $odigoInfos['redirectPhoneNumber'],
                    'Phone' => $odigoInfos['odigoPhoneNumber'],
                    'Title' => $this->fonctionManager->load($request->request->get('utilisateur')['fonction'])->getName(),
                    'Department' => $this->agenceManager->load($request->request->get('utilisateur')['agence'])->getNameInCompany(),
                    'Division' => $this->serviceManager->load($request->request->get('utilisateur')['service'])->getNameInCompany(),
                    'UserPermissionsSupportUser' => $this->serviceCloudAccesManager->load($request->request->get('utilisateur')['fonction'])->getStatus(),
                )
            );
            $this->createNewUser($params, json_encode($newSalesforceUser));
            // Then need to add groupes
            // Then need to add teritories

            return "User created";
        } else {
            return null;
        }
    }
}