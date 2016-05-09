<?php
namespace ActiveDirectoryApiBundle\Services;

use ActiveDirectoryApiBundle\Services\Manager\ActiveDirectoryGroupManager;
use ActiveDirectoryApiBundle\Services\Manager\ActiveDirectoryGroupMatchFonctionManager;
use ActiveDirectoryApiBundle\Services\Manager\ActiveDirectoryGroupMatchServiceManager;
use ActiveDirectoryApiBundle\Services\Manager\ActiveDirectoryOrganisationUnitManager;
use ActiveDirectoryApiBundle\Services\Manager\ActiveDirectoryUserLinkManager;
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
     * @var ActiveDirectoryUserLinkManager;
     */
    protected $activeDirectoryUserLinkManager;

    /**
     * ActiveDirectoryApiService constructor.
     * @param ServiceManager $serviceManager
     * @param UtilisateurManager $utilisateurManager
     * @param ActiveDirectoryGroupManager $activeDirectoryGroupManager
     * @param ActiveDirectoryGroupMatchFonctionManager $activeDirectoryGroupMatchFonctionManager
     * @param ActiveDirectoryGroupMatchServiceManager $activeDirectoryGroupMatchServiceManager
     * @param ActiveDirectoryOrganisationUnitManager $activeDirectoryOrganisationUnitManager
     * @param ActiveDirectoryUserLinkManager $activeDirectoryUserLinkManager
     */
    public function __construct(ServiceManager $serviceManager, UtilisateurManager $utilisateurManager, ActiveDirectoryGroupManager $activeDirectoryGroupManager, ActiveDirectoryGroupMatchFonctionManager $activeDirectoryGroupMatchFonctionManager, ActiveDirectoryGroupMatchServiceManager $activeDirectoryGroupMatchServiceManager, ActiveDirectoryOrganisationUnitManager $activeDirectoryOrganisationUnitManager, ActiveDirectoryUserLinkManager$activeDirectoryUserLinkManager)
    {
        $this->serviceManager                           = $serviceManager;
        $this->utilisateurManager                       = $utilisateurManager;
        $this->activeDirectoryGroupManager              = $activeDirectoryGroupManager;
        $this->activeDirectoryGroupMatchFonctionManager = $activeDirectoryGroupMatchFonctionManager;
        $this->activeDirectoryGroupMatchServiceManager  = $activeDirectoryGroupMatchServiceManager;
        $this->activeDirectoryOrganisationUnitManager   = $activeDirectoryOrganisationUnitManager;
        $this->activeDirectoryUserLinkManager           = $activeDirectoryUserLinkManager;
    }

    /**
     * @param $connectionADparams
     * @return resource
     */
    public function connectAD($connectionADparams)
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
    public function pwd_encryption($newPassword)
    {
        $newPassword = "\"".$newPassword."\"";
        $newPassw = "";
        for ($i = 0; $i < strlen($newPassword); $i++) {
            $newPassw .= "{$newPassword{$i}}\000";
        }
        return $newPassw;
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
     * @param string $userToCreateDn
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
     * @param string $filter
     * @param string[] $elemsToReturn
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
     * @param $ds
     * @param $group
     * @param $group_info
     */
    public function removeUserFromGroup($ds, $group, $group_info)
    {
        try {
            ldap_mod_del($ds, $group, $group_info);
            $this->utilisateurManager->appendSessionMessaging(array('errorCode' => '0', 'message' => 'Utilisateur enlevé du group '.$group.' dans l\'Active Directory'));
        } catch (\Exception $e) {
            $this->utilisateurManager->appendSessionMessaging(array('errorCode' => error_log($e->getMessage()), 'message' => $e->getMessage()));
        }

    }

    /**
     * @param $action
     * @param resource $ds
     * @param $uniqueGroup
     * @param $group_info
     */
    private function switchParseServiceAndFonctionAndDoAction($action, $ds, $uniqueGroup, $group_info)
    {
        if ($action == 'remove') {
            $this->removeUserFromGroup($ds, $uniqueGroup, $group_info);
        }
        if ($action == 'add') {
            $this->addToADGroup($ds, $uniqueGroup, $group_info);
        }
    }


    /**
     * @param $paramsAD
     * @param $serviceId
     * @param $fonctionId
     * @param string $userDn
     * @param string $action
     */
    public function parseServiceAndFonctionAndDoAction($paramsAD, $serviceId, $fonctionId, $userDn, $action)
    {
        $memberOf = [];
        $group_info = [];
        $group_info['member'] = $userDn;
        foreach ($this->activeDirectoryGroupMatchFonctionManager->getRepository()->findBy(array('fonctionId' => $fonctionId), array('id' => 'ASC')) as $fonction) {
            $memberOf[] = $this->activeDirectoryGroupManager->load($fonction->getActiveDirectoryGroupId())->getDn();
        }
        foreach ($this->activeDirectoryGroupMatchServiceManager->getRepository()->findBy(array('serviceId' => $serviceId), array('id' => 'ASC')) as $service) {
            $memberOf[] = $this->activeDirectoryGroupManager->load($service->getActiveDirectoryGroupId())->getDn();
        }
        $ds = $this->connectAD($paramsAD);
        foreach (array_unique($memberOf) as $uniqueGroup) {
            $this->switchParseServiceAndFonctionAndDoAction($action, $ds, $uniqueGroup, $group_info);
        }
        ldap_unbind($ds);
    }

    /**
     * @param $userId
     * @param $paramsAD
     * @param $updatedItem
     * @param $userServiceId
     * @param $userFonctionId
     * @param $oldService
     * @param $oldFonction
     */
    public function modifyInfosForUser($userId, $paramsAD, $updatedItem, $userServiceId, $userFonctionId, $oldService, $oldFonction)
    {
        $ds = $this->connectAD($paramsAD);
        $newrdn = 'CN='.$updatedItem['displayName'];
        $newparent = $this->activeDirectoryUserLinkManager->getRepository()->findOneByUser($userId)->getDn();
        $newcn = $newrdn.','.$newparent;
        $userLinkInfos = $this->activeDirectoryUserLinkManager->getRepository()->findOneByUser($userId);
        try {
            ldap_rename($ds, $userLinkInfos->getCn(), $newrdn, $newparent, true);
            $this->activeDirectoryUserLinkManager->edit($userLinkInfos->getId(), array('cn' => $newcn));
            foreach ($updatedItem as $key => $value) {
                $item[$key] = $value;
                ldap_modify($ds, $newcn, $item);
            }
            $this->parseServiceAndFonctionAndDoAction($paramsAD, $oldService, $oldFonction, $newcn, 'remove');
            $this->parseServiceAndFonctionAndDoAction($paramsAD, $userServiceId, $userFonctionId, $newcn, 'add');

            $this->utilisateurManager->appendSessionMessaging(array('errorCode' => '0', 'message' => 'L\'Utilisateur '.$updatedItem['displayName'].' a été mis à jour  dans l\'Active Directory'));
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
        if ($sendaction == "Créer Session Windows" && ($isCreateInWindows == null || $isCreateInWindows == 0)) {
            $dn_user = 'CN='.$request->request->get('utilisateur')['viewName'].','.$this->activeDirectoryOrganisationUnitManager->load($request->request->get('windows')['dn'])->getDn();
            $ldaprecord = array('cn' => $request->request->get('utilisateur')['viewName'], 'givenName' => $request->request->get('utilisateur')['surname'], 'sn' => $request->request->get('utilisateur')['name'], 'sAMAccountName' => $request->request->get('windows')['identifiant'], 'UserPrincipalName' => $request->request->get('windows')['identifiant'].'@clphoto.local', 'displayName' => $request->request->get('utilisateur')['viewName'], 'name' => $request->request->get('utilisateur')['name'], 'mail' => $request->request->get('utilisateur')['email'], 'UserAccountControl' => '544', 'objectclass' => array('0' => 'top', '1' => 'person', '2' => 'user'), 'unicodePwd' => $this->pwd_encryption($request->request->get('utilisateur')['mainPassword']));
            $this->createUser($paramsAD, $dn_user, $ldaprecord);
            $newUser = $this->executeQueryWithFilter($paramsAD, '(sAMAccountName='.$request->request->get('windows')['identifiant'].')', array("objectSid", "objectGUID", "dn", "name"));
            $this->utilisateurManager->setIsCreateInWindows($request->request->get('utilisateur')['id'], $this->toReadableGuid($newUser[0]['objectguid'][0]));
            $this->activeDirectoryUserLinkManager->add(array('id' => $this->toReadableGuid($newUser[0]['objectguid'][0]), 'cn' =>  $dn_user, 'dn' => $this->activeDirectoryOrganisationUnitManager->load($request->request->get('windows')['dn'])->getDn(), 'identifiant' => $request->request->get('windows')['identifiant'], 'user' => $request->request->get('utilisateur')['id']));
            $this->parseServiceAndFonctionAndDoAction($paramsAD, $request->request->get('utilisateur')['service'], $request->request->get('utilisateur')['fonction'], $dn_user, 'add');
        }
    }
}