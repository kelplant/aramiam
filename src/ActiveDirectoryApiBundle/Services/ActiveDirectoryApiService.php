<?php
namespace ActiveDirectoryApiBundle\Services;

use CoreBundle\Services\Manager\Admin\ServiceManager;
use CoreBundle\Services\Manager\Admin\UtilisateurManager;

/**
 * Class ActiveDirectoryApiService
 * @package CoreBundle\Services
 */
class ActiveDirectoryApiService
{
    protected $serviceManager;

    protected $utilisateurManager;

    /**
     * ActiveDirectoryApiService constructor.
     * @param ServiceManager $serviceManager
     * @param UtilisateurManager $utilisateurManager
     */
    public function __construct($serviceManager, $utilisateurManager)
    {
        $this->serviceManager = $serviceManager;
        $this->utilisateurManager = $utilisateurManager;
    }

    /**
     * @param $connectionADparams
     * @return resource
     */
    private function connectAD($connectionADparams)
    {
        $ds = ldap_connect($connectionADparams['ldaphost']);
        ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_bind($ds, $connectionADparams['ldapUsername'], $connectionADparams['ldapPassword']);

        return $ds;
    }

    /**
     * @param $connectionADparams
     * @param $userToCreateDn
     * @param $userToCreate
     * @return bool|\Exception|string
     */
    public function createUser($connectionADparams, $userToCreateDn, $userToCreate)
    {
        $ds = $this->connectAD($connectionADparams);

        try {
            $e = ldap_add($ds, $userToCreateDn, $userToCreate);
        } catch (\Exception $e) {
            $e = $e->getMessage();
        }
        ldap_unbind($ds);

        return $e;
    }

    /**
     * @param $newPassword
     * @return string
     */
    private function pwd_encryption($newPassword)
    {
        $newPassword = "\"".$newPassword."\"";
        $newPassw = "";
        for ($i = 0; $i < strlen($newPassword); $i++) {
            $newPassw .= "{$newPassword{$i}}\000";
        }
        return $newPassw;
    }

    /**
     * @param $sendaction
     * @param $isCreateInWindows
     * @param $request
     * @return bool|\Exception|string
     */
    public function ifWindowsCreate($sendaction, $isCreateInWindows, $request, $paramsAD)
    {
        if ($sendaction == "Créer Session Windows" && $isCreateInWindows == 0) {
            $dn_user = 'CN='.$request->request->get('utilisateur')['viewName'].','.$this->serviceManager->load($request->request->get('utilisateur')['service'])->getActiveDirectoryDn();
            $ldaprecord = array('cn' => $request->request->get('utilisateur')['viewName'], 'givenName' => $request->request->get('utilisateur')['surname'], 'sn' => $request->request->get('utilisateur')['name'], 'sAMAccountName' => $request->request->get('windows')['identifiant'], 'UserPrincipalName' => $request->request->get('windows')['identifiant'].'@clphoto.local', 'displayName' => $request->request->get('utilisateur')['viewName'], 'name' => $request->request->get('utilisateur')['name'], 'mail' => $request->request->get('utilisateur')['email'], 'UserAccountControl' => '544', 'objectclass' => array('0' => 'top', '1' => 'person', '2' => 'user'), 'unicodePwd' => $this->pwd_encryption($request->request->get('utilisateur')['mainPassword']));
            $this->utilisateurManager->setIsCreateInWindows($request->request->get('utilisateur')['id']);
            return $this->createUser($paramsAD, $dn_user, $ldaprecord);
        } else {
            return null;
        }
    }
}