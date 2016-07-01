<?php
namespace GoogleApiBundle\Services;

use CoreBundle\Services\Manager\Admin\UtilisateurManager;
use Google_Client;
use Google_Auth_AssertionCredentials;
use Google_Service_Directory;
use GoogleApiBundle\Services\Manager\GoogleGroupManager;
use GoogleApiBundle\Services\Manager\GoogleGroupMatchFonctionAndServiceManager;

/**
 * Class AbstractGoogleApiService
 * @package GoogleApiBundle\Services
 */
abstract class AbstractGoogleApiService
{
    /**
     * @var UtilisateurManager
     */
    protected $utilisateurManager;

    /**
     * @var GoogleGroupMatchFonctionAndServiceManager
     */
    protected $googleGroupMatchFonctionAndServiceManager;

    /**
     * @var GoogleGroupManager
     */
    protected $googleGroupManager;

    /**
     * AbstractGoogleApiService constructor.
     * @param UtilisateurManager $utilisateurManager
     * @param GoogleGroupMatchFonctionAndServiceManager $googleGroupMatchFonctionAndServiceManager
     * @param GoogleGroupManager $googleGroupManager
     */
    public function __construct(UtilisateurManager $utilisateurManager, GoogleGroupMatchFonctionAndServiceManager $googleGroupMatchFonctionAndServiceManager, GoogleGroupManager $googleGroupManager)
    {
        $this->utilisateurManager = $utilisateurManager;
        $this->googleGroupMatchFonctionAndServiceManager = $googleGroupMatchFonctionAndServiceManager;
        $this->googleGroupManager = $googleGroupManager;
    }

    /**
     * @param $data
     * @return string
     */
    public function base64safeToBase64($data)
    {
        return str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT);
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
            'https://www.googleapis.com/auth/admin.directory.group',
        );
        $credentials = new Google_Auth_AssertionCredentials($params['user_app_account'], $scopes, $private_key, 'notasecret', 'http://oauth.net/grant_type/jwt/1.0/bearer', $params['admin_account']);
        $client = new Google_Client();
        $client->setAssertionCredentials($credentials);
        $service = new Google_Service_Directory($client);
        return $service;
    }
}
