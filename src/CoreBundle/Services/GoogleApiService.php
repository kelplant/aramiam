<?php
namespace CoreBundle\Services;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Google_Client;
use Google_Auth_AssertionCredentials;
use Google_Service_Directory;
use Exception;
use Google_Service_Directory_User;
use Google_Service_Directory_UserName;

/**
 * Class GoogleApiService
 * @package CoreBundle\Services
 */
class GoogleApiService extends Controller
{
    /**
     * @return Google_Service_Directory
     */
    private function innitApi()
    {
        $params = $this->getParameter('google_api');
        $client_email = $params['user_app_account'];
        $private_key = file_get_contents('../src/xavarr/GoogleApiBundle/Resources/config/'.$params['certificat_name']);
        $scopes = array(
            'https://www.googleapis.com/auth/admin.directory.user',
            'https://www.googleapis.com/auth/admin.directory.group'
        );
        $user_to_impersonate = $params['admin_account'];
        $credentials = new Google_Auth_AssertionCredentials(
            $client_email,
            $scopes,
            $private_key,
            'notasecret',                                 // Default P12 password
            'http://oauth.net/grant_type/jwt/1.0/bearer', // Default grant type
            $user_to_impersonate
        );
        $client = new Google_Client();
        $client->setAssertionCredentials($credentials);
        if ($client->getAuth()->isAccessTokenExpired()) {
            $client->getAuth()->refreshTokenWithAssertion();
        }
        $service = new Google_Service_Directory($client);

        return $service;
    }

    private function isEgalOne($test, $yes, $no)
    {
        if($test == 1) {
            return $yes;
        } else {
            return $no;
        }
    }

    /**
     * @param $userToCreate
     * @return Google_Service_Directory_User
     */
    private function initUserAccount($userToCreate)
    {
        $user = new Google_Service_Directory_User();
        $name = new Google_Service_Directory_UserName();
        $name->setGivenName($userToCreate['prenom']);
        $name->setFamilyName($userToCreate['nom']);
        $user->setName($name);
        $user->setHashFunction("SHA-1");
        $user->setPrimaryEmail($userToCreate['email']);
        $user->setPassword(hash("sha1",$userToCreate['password']));
        // $user->setExternalIds(array("value"=>28790,"type"=>"custom","customType"=>"EmployeeID"));
        return $user;
    }

    /**
     * @param $service
     * @param $email
     * @return mixed
     */
    public function getInfosFromEmail($service, $email)
    {
        if (is_null($service)) {
            $service = $this->innitApi();
        }
        return $service->users->get($email);
    }

    /**
     * @param $service
     * @param $userToCreate
     * @return mixed
     */
    public function createNewUserAccount($service, $userToCreate)
    {
        return $service->users->insert($this->initUserAccount($userToCreate));
    }

    /**
     * @param $service
     * @param $userToCreate
     * @return mixed
     */
    public function updateAccountWithInfos($service, $userToCreate)
    {
        return $service->users->update($userToCreate['email'], $userToCreate);
    }

    /**
     * @param $service
     * @param $userToCreate
     * @return mixed
     */
    public function deleteAccount($service, $userToCreate)
    {
        return $service->users->delete($userToCreate['email']);
    }

    /**
     * @param $userToCreate
     * @return mixed|string
     */
    public function ifEmailNotExistCreateUser($userToCreate)
    {
        $service = $this->innitApi();
        $e = '0';
        try {
            $this->getInfosFromEmail($service, $userToCreate['email']);
        }catch (Exception $e){
            $e = error_log($e->getMessage());
        }
         return $this->isEgalOne($e, $this->createNewUserAccount($service, $userToCreate), 'User Already exist');
    }
//
//    public function indexAction()
//    {
//        $userToCreate = array('nom' => 'aaatest', 'prenom' => 'aaatest', 'email' => 'aaatest@aramisauto.com', 'password' => 'fDFD5fdDF');
//
//        echo $this->testAndCreateUser($userToCreate);
//
//    }
}
