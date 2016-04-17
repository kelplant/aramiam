<?php
namespace CoreBundle\Services;

use CoreBundle\Services\Manager\Admin\UtilisateurManager;
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
class GoogleApiService
{
    protected $utilisateurManager;

    /**
     * GoogleApiService constructor.
     * @param UtilisateurManager $utilisateurManager
     */
    public function __construct($utilisateurManager)
    {
        $this->utilisateurManager = $utilisateurManager;
    }

    /**
     * @param $params
     * @return Google_Service_Directory
     */
    public function innitApi($params)
    {
        $private_key = file_get_contents('../app/config/'.$params['certificat_name']);
        $scopes = array(
            'https://www.googleapis.com/auth/admin.directory.user',
            'https://www.googleapis.com/auth/admin.directory.group'
        );
        $credentials = new Google_Auth_AssertionCredentials(
            $params['user_app_account'],
            $scopes,
            $private_key,
            'notasecret', // Default P12 password
            'http://oauth.net/grant_type/jwt/1.0/bearer', // Default grant type
            $params['admin_account']
        );
        $client = new Google_Client();
        $client->setAssertionCredentials($credentials);
        $service = new Google_Service_Directory($client);
        return $service;
    }

    /**
     * @param $test
     * @param $yes
     * @param $no
     * @return mixed
     */
    private function isEgalOne($test, $yes, $no)
    {
        if ($test == 1) {
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
        $user->setPassword(hash("sha1", $userToCreate['password']));
        return $user;
    }

    /**
     * @param $service
     * @param $email
     * @param $params
     * @return Google_Service_Directory_User
     */
    public function getInfosFromEmail($service, $email, $params)
    {
        if (is_null($service)) {
            $service = $this->innitApi($params);
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
     * @param $params
     * @return mixed
     */
    private function ifEmailNotExistCreateUser($userToCreate, $params)
    {
        $service = $this->innitApi($params);
        $e = '0';
        try {
            $this->getInfosFromEmail($service, $userToCreate['email'], $params);
        } catch (Exception $e) {
            $e = error_log($e->getMessage());
        }
        return $this->isEgalOne($e, $this->createNewUserAccount($service, $userToCreate), 'User Already exist');
    }

    /**
     * @param $sendaction
     * @param $isCreateInGmail
     * @param $request
     */
    public function ifGmailCreate($sendaction, $isCreateInGmail, $request, $params)
    {
        if ($sendaction == "Créer sur Gmail" && $isCreateInGmail == 0) {
            $this->ifEmailNotExistCreateUser(array('nom' => $request->request->get('utilisateur')['name'], 'prenom' => $request->request->get('utilisateur')['surname'], 'email' => $request->request->get('genEmail'), 'password' => $request->request->get('utilisateur')['mainPassword']), $params);
            $this->utilisateurManager->setEmail($request->request->get('utilisateur')['id'], $request->request->get('genEmail'));
        }
    }
}
