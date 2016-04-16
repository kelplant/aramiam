<?php
namespace CoreBundle\Services;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * Class SalesforceApiService
 * @package CoreBundle\Services
 */
class SalesforceApiService
{
    /**
     * @param $params
     * @return mixed
     */
    public function connnect($params)
    {
        $loginurl = "https://test.salesforce.com/services/oauth2/token";

        $params = "grant_type=password"
            . "&client_id=" . $params['consumerKey']
            . "&client_secret=" . $params['secret']
            . "&username=" . $params['username']
            . "&password=" . $params['password'];

        $curl = curl_init($loginurl);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $params);

        $jsonDecoded = json_decode(curl_exec($curl));

        $_SESSION['access_token'] = $jsonDecoded->access_token;
        $_SESSION['instance_url'] = $jsonDecoded->instance_url;

        return $jsonDecoded;
    }

    /**
     * @param $query
     * @return mixed
     */
    private function initExcecuteQuery($query)
    {
        $url = $_SESSION['instance_url'].'/services/data/v36.0/query?q='.urlencode($query);

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER,
            array('Authorization: OAuth '.$_SESSION['access_token']));
        $json_response = curl_exec($curl);
        curl_close($curl);
        return json_decode($json_response, true);
    }

    /**
     * @param $query
     * @param $params
     * @return mixed|string
     */
    public function executeQuery($query, $params)
    {
        try {
            return $this->initExcecuteQuery($query);
        } catch (\Exception $e) {
            $this->connnect($params);
            try {
                return $this->initExcecuteQuery($query);
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }
    }

    /**
     * @param $params
     * @return mixed
     */
    public function getListOfProfiles($params)
    {
        $query = "SELECT Id,Name,UserLicenseId,UserType FROM Profile";
        return $this->executeQuery($query, $params);
    }

    /**
     * @param $emailToLook
     * @param $params
     * @return mixed
     */
    public function getAccountByUsername($emailToLook, $params)
    {
        var_dump($_SESSION['access_token']);
        $query = "SELECT Id,Username FROM User WHERE Username = '".$emailToLook."'";
        return $this->executeQuery($query, $params);
    }
}