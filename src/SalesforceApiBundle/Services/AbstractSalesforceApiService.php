<?php
namespace SalesforceApiBundle\Services;

use AppBundle\Services\Manager\ParametersManager;

use Symfony\Component\Config\Definition\Exception\Exception;
use SalesforceApiBundle\Services\Manager\SalesforceTokenStoreManager as SalesforceTokenStore;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

/**
 * Class AbstractSalesforceApiService
 * @package SalesforceApiBundle\Services
 */
class AbstractSalesforceApiService
{
    /**
     * @var SalesforceTokenStore
     */
    protected $tokenManager;

    /**
     * @var TokenStorage
     */
    protected $securityContext;

    /**
     * @var ParametersManager
     */
    protected $parametersManager;

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
    public function connnect($params)
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
        try {
            $this->connnect($params);
            return $this->initExcecuteQuery($query, $params, $json, $action);
        } catch (Exception $e) {
            $this->tokenManager->appendSessionMessaging(array('errorCode' => error_log($e->getMessage()), 'message' => $e->getMessage()));
        }
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
     * @param SalesforceTokenStore $tokenManager
     * @return AbstractSalesforceApiService
     */
    public function setTokenManager($tokenManager)
    {
        $this->tokenManager = $tokenManager;
        return $this;
    }

    /**
     * @param TokenStorage $securityContext
     * @return AbstractSalesforceApiService
     */
    public function setSecurityContext($securityContext)
    {
        $this->securityContext = $securityContext;
        return $this;
    }

    /**
     * @param ParametersManager $parametersManager
     * @return AbstractSalesforceApiService
     */
    public function setParametersManager($parametersManager)
    {
        $this->parametersManager = $parametersManager;
        return $this;
    }
}