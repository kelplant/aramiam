<?php
namespace ActiveDirectoryApiBundle\Services;

use ActiveDirectoryApiBundle\Services\Manager\ActiveDirectoryGroupManager;
use ActiveDirectoryApiBundle\Services\Manager\ActiveDirectoryGroupMatchFonctionManager;
use ActiveDirectoryApiBundle\Services\Manager\ActiveDirectoryGroupMatchServiceManager;
use CoreBundle\Services\Manager\Admin\ServiceManager;
use CoreBundle\Services\Manager\Admin\UtilisateurManager;

/**
 * Class ActiveDirectoryApiService
 * @package ActiveDirectoryApiBundle\Services
 */
class ActiveDirectoryApiService
{
    protected $serviceManager;

    protected $utilisateurManager;

    protected $activeDirectoryGroupManager;

    protected $activeDirectoryGroupMatchFonctionManager;

    protected $activeDirectoryGroupMatchServiceManager;
    /**
     * ActiveDirectoryApiService constructor.
     * @param ServiceManager $serviceManager
     * @param UtilisateurManager $utilisateurManager
     * @param ActiveDirectoryGroupManager $activeDirectoryGroupManager
     * @param ActiveDirectoryGroupMatchFonctionManager $activeDirectoryGroupMatchFonctionManager
     * @param ActiveDirectoryGroupMatchServiceManager $activeDirectoryGroupMatchServiceManager
     */
    public function __construct($serviceManager, $utilisateurManager, $activeDirectoryGroupManager, $activeDirectoryGroupMatchFonctionManager, $activeDirectoryGroupMatchServiceManager)
    {
        $this->serviceManager = $serviceManager;
        $this->utilisateurManager = $utilisateurManager;
        $this->activeDirectoryGroupManager = $activeDirectoryGroupManager;
        $this->activeDirectoryGroupMatchFonctionManager = $activeDirectoryGroupMatchFonctionManager;
        $this->activeDirectoryGroupMatchServiceManager = $activeDirectoryGroupMatchServiceManager;
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
     */
    public function createUser($connectionADparams, $userToCreateDn, $userToCreate)
    {
        $ds = $this->connectAD($connectionADparams);

        try {
            $e = ldap_add($ds, $userToCreateDn, $userToCreate);
            $this->utilisateurManager->appendSessionMessaging(array('errorCode' => '0', 'message' => 'Utilisateur créé dans l\'Active Directory '.$e));
        } catch (\Exception $e) {
            $this->utilisateurManager->appendSessionMessaging(array('errorCode' => error_log($e->getMessage()), 'message' => $e->getMessage()));
        }
        ldap_unbind($ds);
    }

    /**
     * @param $connectionADparams
     * @return array
     */
    public function getListeofGroupes($connectionADparams)
    {
        $ds = $this->connectAD($connectionADparams);
        $filter = '(objectCategory=group)';
        $elemsToReturn = array("objectSid", "dn", "name");
        try {
            $sr = ldap_search($ds, $connectionADparams['ldapBaseDN'], $filter, $elemsToReturn);
            return ldap_get_entries($ds, $sr);
        } catch (\Exception $e) {
            $this->utilisateurManager->appendSessionMessaging(array('errorCode' => error_log($e->getMessage()), 'message' => $e->getMessage()));
        }
    }

    /**
     * @param $connectionADparams
     * @param $accountName
     * @return array
     */
    public function getOneUserByAccountName($connectionADparams, $accountName)
    {
        $ds = $this->connectAD($connectionADparams);
        $filter = '(sAMAccountName='.$accountName.')';
        $elemsToReturn = array("objectSid", "dn", "name");
        try {
            $sr = ldap_search($ds, $connectionADparams['ldapBaseDN'], $filter, $elemsToReturn);
            return ldap_get_entries($ds, $sr);
        } catch (\Exception $e) {
            $this->utilisateurManager->appendSessionMessaging(array('errorCode' => error_log($e->getMessage()), 'message' => $e->getMessage()));
        }
    }

    /**
     * @param $connectionADparams
     * @param $groupDn
     * @param $userDn
     */
    public function addToADGroup($connectionADparams, $groupDn, $userDn)
    {
        $ds = $this->connectAD($connectionADparams);
        try {
            ldap_mod_add($ds,$groupDn,$userDn);
            $this->utilisateurManager->appendSessionMessaging(array('errorCode' => '0', 'message' => 'Utilisateur ajouté au group dans l\'Active Directory '.$groupDn));
        } catch (\Exception $e) {
            $this->utilisateurManager->appendSessionMessaging(array('errorCode' => error_log($e->getMessage()), 'message' => $e->getMessage()));
        }
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
     * @param $paramsAD
     * @param $request
     */
    private function addNewUserToGroups($paramsAD, $request)
    {
        $memberOf = [];
        $group_info = [];
        $group_info['member'] = $this->getOneUserByAccountName($paramsAD, $request->request->get('windows')['identifiant'])[0]['dn'];
        foreach ($this->activeDirectoryGroupMatchFonctionManager->getRepository()->findBy(array('fonctionId' => $request->request->get('utilisateur')['fonction']), array ('id' => 'ASC')) as $fonction) {
            $memberOf[] = $this->activeDirectoryGroupManager->load($fonction->getActiveDirectoryGroupId())->getDn();
        }
        foreach ($this->activeDirectoryGroupMatchServiceManager->getRepository()->findBy(array('serviceId' => $request->request->get('utilisateur')['service']), array ('id' => 'ASC')) as $service) {
            $memberOf[] = $this->activeDirectoryGroupManager->load($service->getActiveDirectoryGroupId())->getDn();
        }
        foreach (array_unique($memberOf) as $uniqueGroup) {
            $this->addToADGroup($paramsAD, $uniqueGroup, $group_info);
        }
    }
    /**
     * @param $sendaction
     * @param $isCreateInWindows
     * @param $request
     * @param $paramsAD
     */
    public function ifWindowsCreate($sendaction, $isCreateInWindows, $request, $paramsAD)
    {
        if ($sendaction == "Créer Session Windows" && $isCreateInWindows == 0) {
            $dn_user = 'CN='.$request->request->get('utilisateur')['viewName'].','.$this->serviceManager->load($request->request->get('utilisateur')['service'])->getActiveDirectoryDn();
            $ldaprecord = array('cn' => $request->request->get('utilisateur')['viewName'], 'givenName' => $request->request->get('utilisateur')['surname'], 'sn' => $request->request->get('utilisateur')['name'], 'sAMAccountName' => $request->request->get('windows')['identifiant'], 'UserPrincipalName' => $request->request->get('windows')['identifiant'].'@clphoto.local', 'displayName' => $request->request->get('utilisateur')['viewName'], 'name' => $request->request->get('utilisateur')['name'], 'mail' => $request->request->get('utilisateur')['email'], 'UserAccountControl' => '544', 'objectclass' => array('0' => 'top', '1' => 'person', '2' => 'user'), 'unicodePwd' => $this->pwd_encryption($request->request->get('utilisateur')['mainPassword']));
            $this->utilisateurManager->setIsCreateInWindows($request->request->get('utilisateur')['id']);
            $this->createUser($paramsAD, $dn_user, $ldaprecord);
            $this->addNewUserToGroups($paramsAD, $request);
        }
    }
}