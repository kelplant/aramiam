<?php
namespace ActiveDirectoryApiBundle\Services;

use ActiveDirectoryApiBundle\Services\Manager\ActiveDirectoryGroupManager;
use ActiveDirectoryApiBundle\Services\Manager\ActiveDirectoryGroupMatchFonctionManager;
use ActiveDirectoryApiBundle\Services\Manager\ActiveDirectoryGroupMatchServiceManager;
use ActiveDirectoryApiBundle\Services\Manager\ActiveDirectoryOrganisationUnitManager;
use CoreBundle\Services\Manager\Admin\ServiceManager;
use CoreBundle\Services\Manager\Admin\UtilisateurManager;

/**
 * Class ActiveDirectoryApiService
 * @package ActiveDirectoryApiBundle\Services
 */
class ActiveDirectoryApiService
{
    /**
     * @var ServiceManager
     */
    protected $serviceManager;

    /**
     * @var UtilisateurManager
     */
    protected $utilisateurManager;

    /**
     * @var ActiveDirectoryGroupManager
     */
    protected $activeDirectoryGroupManager;

    /**
     * @var ActiveDirectoryGroupMatchFonctionManager
     */
    protected $activeDirectoryGroupMatchFonctionManager;

    /**
     * @var ActiveDirectoryGroupMatchServiceManager
     */
    protected $activeDirectoryGroupMatchServiceManager;

    /**
     * @var ActiveDirectoryOrganisationUnitManager
     */
    protected $activeDirectoryOrganisationUnitManager;

    /**
     * ActiveDirectoryApiService constructor.
     * @param ServiceManager $serviceManager
     * @param UtilisateurManager $utilisateurManager
     * @param ActiveDirectoryGroupManager $activeDirectoryGroupManager
     * @param ActiveDirectoryGroupMatchFonctionManager $activeDirectoryGroupMatchFonctionManager
     * @param ActiveDirectoryGroupMatchServiceManager $activeDirectoryGroupMatchServiceManager
     * @param ActiveDirectoryOrganisationUnitManager $activeDirectoryOrganisationUnitManager
     */
    public function __construct(ServiceManager $serviceManager, UtilisateurManager $utilisateurManager, ActiveDirectoryGroupManager $activeDirectoryGroupManager, ActiveDirectoryGroupMatchFonctionManager $activeDirectoryGroupMatchFonctionManager, ActiveDirectoryGroupMatchServiceManager $activeDirectoryGroupMatchServiceManager, ActiveDirectoryOrganisationUnitManager $activeDirectoryOrganisationUnitManager)
    {
        $this->serviceManager                           = $serviceManager;
        $this->utilisateurManager                       = $utilisateurManager;
        $this->activeDirectoryGroupManager              = $activeDirectoryGroupManager;
        $this->activeDirectoryGroupMatchFonctionManager = $activeDirectoryGroupMatchFonctionManager;
        $this->activeDirectoryGroupMatchServiceManager  = $activeDirectoryGroupMatchServiceManager;
        $this->activeDirectoryOrganisationUnitManager   = $activeDirectoryOrganisationUnitManager;
    }

    /**
     * @param $connectionADparams
     * @return resource
     */
    private function connectAD($connectionADparams)
    {
        try {
            $ds = ldap_connect($connectionADparams['ldaphost']);
            ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_bind($ds, $connectionADparams['ldapUsername'], $connectionADparams['ldapPassword']);
            return $ds;
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
    private function addNewUserToGroups($paramsAD, $request, $newUser)
    {
        $memberOf = [];
        $group_info = [];
        $group_info['member'] = $newUser[0]['dn'];
        foreach ($this->activeDirectoryGroupMatchFonctionManager->getRepository()->findBy(array('fonctionId' => $request->request->get('utilisateur')['fonction']), array('id' => 'ASC')) as $fonction) {
            $memberOf[] = $this->activeDirectoryGroupManager->load($fonction->getActiveDirectoryGroupId())->getDn();
        }
        foreach ($this->activeDirectoryGroupMatchServiceManager->getRepository()->findBy(array('serviceId' => $request->request->get('utilisateur')['service']), array('id' => 'ASC')) as $service) {
            $memberOf[] = $this->activeDirectoryGroupManager->load($service->getActiveDirectoryGroupId())->getDn();
        }
        $ds = $this->connectAD($paramsAD);
        foreach (array_unique($memberOf) as $uniqueGroup) {
            $this->addToADGroup($ds, $uniqueGroup, $group_info);
        }
        ldap_unbind($ds);
    }

    /**
     * @param $guidFromAd
     * @return string
     */
    public function toReadableGuid($guidFromAd)
    {
        $hex = unpack("H*hex", $guidFromAd)["hex"];
        return substr($hex, -26, 2).substr($hex, -28, 2).substr($hex, -30, 2).substr($hex, -32, 2)."-".substr($hex, -22, 2).substr($hex, -24, 2)."-".substr($hex, -18, 2).substr($hex, -20, 2)."-".substr($hex, -16, 4)."-".substr($hex, -12, 12);
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
            ldap_add($ds, $userToCreateDn, $userToCreate);
            $this->utilisateurManager->appendSessionMessaging(array('errorCode' => '0', 'message' => 'Utilisateur créé dans l\'Active Directory '.$userToCreateDn));
        } catch (\Exception $e) {
            $this->utilisateurManager->appendSessionMessaging(array('errorCode' => error_log($e->getMessage()), 'message' => $e->getMessage()));
        }
        ldap_unbind($ds);
    }

    /**
     * @param $connectionADparams
     * @return array
     */
    public function executeQueryWithFilter($connectionADparams, $filter, $elemsToReturn)
    {
        $ds = $this->connectAD($connectionADparams);
        try {
            $entries = ldap_get_entries($ds, ldap_search($ds, $connectionADparams['ldapBaseDN'], $filter, $elemsToReturn));
            ldap_unbind($ds);
            return $entries;
        } catch (\Exception $e) {
            $this->utilisateurManager->appendSessionMessaging(array('errorCode' => error_log($e->getMessage()), 'message' => $e->getMessage()));
            return array('errorCode' => error_log($e->getMessage()), 'message' => $e->getMessage());
        }
    }

    /**
     * @param $ds
     * @param $groupDn
     * @param $userDn
     */
    public function addToADGroup($ds, $groupDn, $userDn)
    {
        try {
            ldap_mod_add($ds, $groupDn, $userDn);
            $this->utilisateurManager->appendSessionMessaging(array('errorCode' => '0', 'message' => 'Utilisateur ajouté au group dans l\'Active Directory '.$groupDn));
        } catch (\Exception $e) {
            $this->utilisateurManager->appendSessionMessaging(array('errorCode' => error_log($e->getMessage()), 'message' => $e->getMessage()));
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
        if ($sendaction == "Créer Session Windows" && $isCreateInWindows == null) {
            $dn_user = 'CN='.$request->request->get('utilisateur')['viewName'].','.$this->activeDirectoryOrganisationUnitManager->load($request->request->get('windows')['dn'])->getDn();
            $ldaprecord = array('cn' => $request->request->get('utilisateur')['viewName'], 'givenName' => $request->request->get('utilisateur')['surname'], 'sn' => $request->request->get('utilisateur')['name'], 'sAMAccountName' => $request->request->get('windows')['identifiant'], 'UserPrincipalName' => $request->request->get('windows')['identifiant'].'@clphoto.local', 'displayName' => $request->request->get('utilisateur')['viewName'], 'name' => $request->request->get('utilisateur')['name'], 'mail' => $request->request->get('utilisateur')['email'], 'UserAccountControl' => '544', 'objectclass' => array('0' => 'top', '1' => 'person', '2' => 'user'), 'unicodePwd' => $this->pwd_encryption($request->request->get('utilisateur')['mainPassword']));
            $this->createUser($paramsAD, $dn_user, $ldaprecord);
            $newUser = $this->executeQueryWithFilter($paramsAD, '(sAMAccountName='.$request->request->get('windows')['identifiant'].')', array("objectSid", "objectGUID", "dn", "name"));
            $this->utilisateurManager->setIsCreateInWindows($request->request->get('utilisateur')['id'], $this->toReadableGuid($newUser[0]['objectguid']));
            $this->addNewUserToGroups($paramsAD, $request, $newUser);
        }
    }
}