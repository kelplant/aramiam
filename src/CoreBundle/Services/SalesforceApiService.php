<?php
namespace CoreBundle\Services;
use CoreBundle\Factory\Applications\Salesforce\SalesforceUserFactory;
use CoreBundle\Services\Manager\Admin\AgenceManager;
use CoreBundle\Services\Manager\Admin\FonctionManager;
use CoreBundle\Services\Manager\Admin\ServiceManager;
use CoreBundle\Services\Manager\Applications\ProsodieOdigoManager;
use Symfony\Component\Config\Definition\Exception\Exception;
use CoreBundle\Services\Manager\Applications\Salesforce\SalesforceTokenStoreManager as SalesforceTokenStore;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SalesforceApiService
 * @package CoreBundle\Services
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

    /**
     * SalesforceApiService constructor.
     * @param SalesforceTokenStore $tokenManager
     * @param SalesforceUserFactory $salesforceUserFactory
     * @param ProsodieOdigoManager $prosodieOdigo
     * @param AgenceManager $agenceManager
     * @param ServiceManager $serviceManager
     * @param FonctionManager $fonctionManager
     */
    public function __construct($tokenManager, $securityContext, $salesforceUserFactory, $prosodieOdigo, $agenceManager, $serviceManager, $fonctionManager)
    {
        $this->tokenManager = $tokenManager;
        $this->securityContext = $securityContext;
        $this->salesforceUserFactory = $salesforceUserFactory;
        $this->prosodieOdigo = $prosodieOdigo;
        $this->agenceManager = $agenceManager;
        $this->serviceManager = $serviceManager;
        $this->fonctionManager = $fonctionManager;
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
     * @return mixed
     */
    private function connnect($params)
    {
        $loginurl = "https://test.salesforce.com/services/oauth2/token";
        $params = "grant_type=password"
            . "&client_id=".$params['consumerKey']
            . "&client_secret=".$params['secret']
            . "&username=".$params['username']
            . "&password=".$params['password'];
        $curl = $this->curlInitAndHeader($loginurl);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
        $jsonDecoded = json_decode(curl_exec($curl));

        return $this->tokenManager->updateOrAdd(array('username' => $this->securityContext->getToken()->getUser()->getUsername(), 'access_token' => $jsonDecoded->access_token, 'instance_url' => $jsonDecoded->instance_url, 'issued_at' => $jsonDecoded->issued_at));
    }

    /**
     * @param string $query
     * @param $params
     * @return mixed
     */
    private function initExcecuteQuery($query, $params)
    {
        if (is_null($this->tokenManager->loadByUsername($this->securityContext->getToken()->getUser()->getUsername()))) {
            $this->connnect($params);
        }
        $tokenInfos = $this->tokenManager->loadByUsername($this->securityContext->getToken()->getUser()->getUsername());
        $url = $tokenInfos->getInstanceUrl().'/services/data/v36.0/query?q='.urlencode($query);
        $curl = $this->curlInitAndHeader($url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: OAuth '.$tokenInfos->getAccessToken()));
        $json_response = curl_exec($curl);
        curl_close($curl);
        return json_decode($json_response, true);
    }

    /**
     * @param string $query
     * @param $params
     * @return mixed|string
     */
    public function executeQuery($query, $params)
    {
        try {
            $queryResult = $this->initExcecuteQuery($query, $params);
            if (isset($queryResult[0]['message']) == "Session expired or invalid") {
                $this->connnect($params);
                try {
                    return $this->initExcecuteQuery($query, $params);
                } catch (Exception $e) {
                    return $e->getMessage();
                }
            }
            return $queryResult;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param $params
     * @return mixed
     */
    public function getListOfProfiles($params)
    {
        $query = "SELECT Id,Name,UserLicenseId,UserType FROM Profile ORDER BY Name ASC NULLS FIRST";
        return $this->executeQuery($query, $params);
    }

    /**
     * @param $params
     * @return mixed
     */
    public function getListOfGroupes($params)
    {
        $query = "SELECT Id,Name FROM Group ORDER BY Name ASC NULLS LAST";
        return $this->executeQuery($query, $params);
    }

    /**
     * @param $emailToLook
     * @param $params
     * @return mixed
     */
    public function getAccountByUsername($emailToLook, $params)
    {
        $query = "SELECT Id,Username,CallCenterId FROM User WHERE Username = '".$emailToLook."'";
        return $this->executeQuery($query, $params);
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

    private function ifOdigoCreated($isCreatedInOdigo)
    {
        if ($isCreatedInOdigo != 0) {
            $odigoInfos = $this->prosodieOdigo->load($isCreatedInOdigo);
            return array('callcenterId' => "04va0000000TR5QAAW", 'odigoExtension' => $odigoInfos->getOdigoExtension(), 'odigoPhoneNumber' => $odigoInfos->getOdigoPhoneNumber(), 'redirectPhoneNumber' => $odigoInfos->getOdigoRedirectPhoneNumber());
        } else {
            return array('callcenterId' => null, 'odigoExtension' => null, 'odigoPhoneNumber' => null, 'redirectPhoneNumber' => null);
        }
    }

    /**
     * @param $sendaction
     * @param $isCreateInSalesforce
     * @param Request $request
     * @return \CoreBundle\Entity\Applications\Salesforce\SalesforceUser|null
     */
    public function ifSalesforceCreate($sendaction, $isCreateInSalesforce, Request $request)
    {
        if ($sendaction == "Créer sur Salesforce" && $isCreateInSalesforce == 0) {
            $nickname = $this->shortNickName($request->request->get('utilisateur')['name'], $request->request->get('utilisateur')['surname']);
            $odigoInfos = $this->ifOdigoCreated($request->request->get('utilisateur')['isCreateInOdigo']);
            return $this->salesforceUserFactory->createFromEntity(
                array(
                    'Username' => $request->request->get('utilisateur')['email'],
                    'LastName' => $request->request->get('utilisateur')['name'],
                    'FirstName' => $request->request->get('utilisateur')['surname'],
                    'Email' => $request->request->get('utilisateur')['email'],
                    'TimeZoneSidKey' => 'Europe/Paris',
                    'Alias' => $nickname,
                    'CommunityNickname' => $nickname."aramisauto",
                    'IsActive' => true,
                    'LocaleSidKey' => "fr_FR",
                    'EmailEncodingKey' => "ISO-8859-1",
                    'ProfileId' => $request->request->get('salesforce')['profile'],
                    'LanguageLocaleKey' => "FR",
                    'UserPermissionsMobileUser' => true,
                    'UserPreferencesDisableAutoSubForFeeds' => false,
                    'CallCenterId' => $odigoInfos['callcenterId'],
                    'Street' => '23 Avenue Aristide Briand', //Addresse from Robusto Agence
                    'City' => 'Arcueil', //City from Robusto Agence
                    'PostalCode' => '94110', //CodePostal from Robusto Agence
                    'State ' => 'France', //Pays from Robusto Agence
                    'ExternalID__c' => '9999', #Id from Robusto
                    'Fax' => '0606060606', //Fax from Robusto Agence
                    'Extension' =>  $odigoInfos['odigoExtension'],
                    'OdigoCti__Odigo_login__c' => $odigoInfos['odigoExtension'],
                    'Telephone_interne__c' => $odigoInfos['redirectPhoneNumber'],
                    'Phone' => $odigoInfos['odigoPhoneNumber'],
                    'Title' => $request->request->get('salesforce')['civilite'],
                    'DepartementRegion__c' => $this->agenceManager->load($request->request->get('utilisateur')['agence'])->getNameInCompany(),
                    'Department' => $this->agenceManager->load($request->request->get('utilisateur')['agence'])->getNameInCompany(),
                    'Division' => $this->serviceManager->load($request->request->get('utilisateur')['service'])->getNameInCompany(),
                )
            );
        } else {
            return null;
        }
    }
}