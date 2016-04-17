<?php
namespace CoreBundle\Services;
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

    /**
     * SalesforceApiService constructor.
     * @param SalesforceTokenStore $tokenManager
     */
    public function __construct($tokenManager, $securityContext)
    {
        $this->tokenManager = $tokenManager;
        $this->securityContext = $securityContext;
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

        return $this->tokenManager->add(array('username' => $this->securityContext->getToken()->getUser()->getUsername(), 'access_token' => $jsonDecoded->access_token, 'instance_url' => $jsonDecoded->instance_url, 'issued_at' => $jsonDecoded->issued_at));
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
            if (isset($queryResult[0]['message']) == "Session expired or invalid" ) {
                $this->connnect($params);
            }
            return $queryResult;
        } catch (\Exception $e) {
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
     * @param $emailToLook
     * @param $params
     * @return mixed
     */
    public function getAccountByUsername($emailToLook, $params)
    {
        $query = "SELECT Id,Username FROM User WHERE Username = '".$emailToLook."'";
        return $this->executeQuery($query, $params);
    }

    /**
     * @param $sendaction
     * @param $isCreateInSalesforce
     * @param $request
     */
    public function ifSalesforceCreate($sendaction, $isCreateInSalesforce, Request $request)
    {
        if ($sendaction == "Créer sur Salesforce" && $isCreateInSalesforce == 0) {
            $newUser = $this->get('core.factory.apps.salesforce.salesforce_user')->createFromEntity(
                array(
                    'Username' => null,
                    'LastName' => null,
                    'FirstName' => null,
                    'Email' => null,
                    'TimeZoneSidKey' => null,
                    'Alias' => null,
                    'CommunityNickname' => null,
                    'IsActive' => null,
                    'LocaleSidKey' => null,
                    'EmailEncodingKey' => null,
                    'ProfileId' => null,
                    'LanguageLocaleKey' => null,
                    'UserPermissionsMobileUser' => null,
                    'UserPreferencesDisableAutoSubForFeeds' => null,
                )
            );
        }
    }
}