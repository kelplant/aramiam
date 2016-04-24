<?php
namespace SalesforceApiBundle\Services;

use AppBundle\Services\Manager\ParametersManager;

use Symfony\Component\Config\Definition\Exception\Exception;
use SalesforceApiBundle\Services\Manager\SalesforceTokenStoreManager as SalesforceTokenStore;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

/**
 * Class SalesforceApiService
 * @package SalesforceApiBundle\Services
 */
class SalesforceApiService
{
    protected $tokenManager;

    protected $securityContext;

    protected $parametersManager;

    /**
     * SalesforceApiService constructor.
     * @param SalesforceTokenStore $tokenManager
     * @param TokenStorage $securityContext
     * @param ParametersManager $parametersManager
     */
    public function __construct($tokenManager, $securityContext, $parametersManager)
    {
        $this->tokenManager = $tokenManager;
        $this->securityContext = $securityContext;
        $this->parametersManager = $parametersManager;
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
        $this->tokenManager->appendSessionMessaging(array('errorCode' => curl_exec($curl), 'message' => curl_getinfo($curl, CURLINFO_HTTP_CODE)));
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
        $queryResult = $this->initExcecuteQuery($query, $params, $json, $action);
        if (isset($queryResult['errorCode']) && $queryResult['errorCode'] == '200') {
            return $queryResult;
        } elseif (isset($queryResult["error"]) && json_decode($queryResult["error"])[0]->message == "Session expired or invalid") {
            $this->connnect($params);
            try {
                return $this->initExcecuteQuery($query, $params, $json, $action);
            } catch (Exception $e) {
                $this->tokenManager->appendSessionMessaging(array('errorCode' => error_log($e->getMessage()), 'message' => $e->getMessage()));
            }
        } else {
            return $queryResult;
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
}