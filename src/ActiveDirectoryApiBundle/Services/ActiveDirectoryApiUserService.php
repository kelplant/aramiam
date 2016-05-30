<?php
namespace ActiveDirectoryApiBundle\Services;

/**
 * Class ActiveDirectoryApiUserService
 * @package ActiveDirectoryApiBundle\Services
 */
class ActiveDirectoryApiUserService extends AbstractActiveDirectoryApiService
{
    /**
     * @var ActiveDirectoryApiGroupService
     */
    protected $activeDirectoryApiGroupService;

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
     * @param $connectionADparams
     * @param $utilisateurId
     */
    public function deleteUserFromAD($connectionADparams, $utilisateurId)
    {
        $ds = $this->connectAD($connectionADparams);
        $userLinkInfos = $this->activeDirectoryUserLinkManager->getRepository()->findOneByUser($utilisateurId);
        try {
            ldap_delete($ds, $userLinkInfos->getCn());
            $this->activeDirectoryUserLinkManager->removeByUserId($utilisateurId);
            $this->utilisateurManager->edit($utilisateurId, array('isCreateInWindows' => null));
            $this->utilisateurManager->appendSessionMessaging(array('errorCode' => '0', 'message' => 'Le compte Active Directory a été supprimé'));
        } catch (\Exception $e) {
            $this->utilisateurManager->appendSessionMessaging(array('errorCode' => error_log($e->getMessage()), 'message' => $e->getMessage()));
        }
    }

    /**
     * @param $tabToSend
     */
    public function modifyInfosForUser($tabToSend, $activeDirectoryParams)
    {
        $ds = $this->connectAD($activeDirectoryParams);
        $newrdn = 'CN='.$tabToSend['newDatas']['displayName'];
        $userLinkInfos = $this->activeDirectoryUserLinkManager->getRepository()->findOneByUser($tabToSend['utilisateurId']);
        $newcn = $newrdn.','.$userLinkInfos->getDn();
        $item = [];
        try {
            ldap_rename($ds, $userLinkInfos->getCn(), $newrdn, $userLinkInfos->getDn(), true);
            $this->activeDirectoryUserLinkManager->edit($userLinkInfos->getId(), array('cn' => $newcn));
            foreach ($tabToSend['newDatas'] as $key => $value) {
                $item[$key] = $value;
                ldap_modify($ds, $newcn, $item);
            }
            $this->activeDirectoryApiGroupService->progagateInActiveDirectoryIfServiceOrFonctionModified($tabToSend, $activeDirectoryParams, $newcn);
            $this->utilisateurManager->appendSessionMessaging(array('errorCode' => '0', 'message' => 'L\'Utilisateur '.$tabToSend['newDatas']['displayName'].' a été mis à jour  dans l\'Active Directory'));
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
            $this->activeDirectoryApiGroupService->parseServiceAndFonctionAndDoAction($paramsAD, $request->request->get('utilisateur')['service'], $request->request->get('utilisateur')['fonction'], $dn_user, 'add');
        }
    }

    /**
     * @param $ds
     * @param $actualWindowsLink
     * @param $newrdn
     * @param $parent
     * @param $newcn
     * @param $viewName
     */
    private function renameIfWindowsUpdate($ds, $actualWindowsLink, $newrdn, $parent, $newcn, $viewName)
    {
        if ($newrdn != $actualWindowsLink->getCn()) {
            try {
                ldap_rename($ds, $actualWindowsLink->getCn(), $newrdn, $parent, true);
                $this->activeDirectoryUserLinkManager->edit($actualWindowsLink->getId(), array('dn' => $parent, 'cn' => $newcn));
                $this->utilisateurManager->appendSessionMessaging(array('errorCode' => '0', 'message' => 'L\'Utilisateur '.$viewName.' a été déplacé  dans l\'Active Directory'));
            } catch (\Exception $e) {
                $this->utilisateurManager->appendSessionMessaging(array('errorCode' => error_log($e->getMessage()), 'message' => $e->getMessage()));
            }
        }
    }

    /**
     * @param $ds
     * @param $newcn
     * @param $item
     * @param $actualWindowsLink
     * @param $viewName
     * @param $identifiant
     */
    private function modifyIfWindowsUpdate($ds, $newcn, $item, $actualWindowsLink, $viewName, $identifiant)
    {
        if ($identifiant != $actualWindowsLink->getIdentifiant()) {
            try {
                ldap_modify($ds, $newcn, $item);
                $this->activeDirectoryUserLinkManager->edit($actualWindowsLink->getId(), array('identifiant' => $identifiant));
                $this->utilisateurManager->appendSessionMessaging(array('errorCode' => '0', 'message' => 'L\'Utilisateur '.$viewName.' a été mis à jour  dans l\'Active Directory'));
            } catch (\Exception $e) {
                $this->utilisateurManager->appendSessionMessaging(array('errorCode' => error_log($e->getMessage()), 'message' => $e->getMessage()));
            }
        }
    }

    /**
     * @param $sendaction
     * @param $request
     * @param $paramsAD
     */
    public function ifWindowsUpdate($sendaction, $request, $paramsAD)
    {
        if ($sendaction == "Mise à jour Session Windows") {
            $actualWindowsLink = $this->activeDirectoryUserLinkManager->getRepository()->findOneByUser($request->request->get('utilisateur')['id']);
            $actualUserInfos = $this->utilisateurManager->load($request->request->get('utilisateur')['id']);
            $ds = $this->connectAD($paramsAD);
            $newrdn = 'CN='.$actualUserInfos->getViewName();
            $parent = $this->activeDirectoryOrganisationUnitManager->load($request->request->get('windows')['dn'])->getDn();
            $newcn = $newrdn.','.$parent;
            $item = array('sAMAccountName' => $request->request->get('windows')['identifiant'], 'UserPrincipalName' => $request->request->get('windows')['identifiant']);
            $this->renameIfWindowsUpdate($ds, $actualWindowsLink, $newrdn, $parent, $newcn, $actualUserInfos->getViewName());
            $this->modifyIfWindowsUpdate($ds, $newcn, $item, $actualWindowsLink, $actualUserInfos->getViewName(), $request->request->get('windows')['identifiant']);
        }
    }

    /**
     * @param ActiveDirectoryApiGroupService $activeDirectoryApiGroupService
     * @return ActiveDirectoryApiUserService
     */
    public function setActiveDirectoryApiGroupService($activeDirectoryApiGroupService)
    {
        $this->activeDirectoryApiGroupService = $activeDirectoryApiGroupService;
        return $this;
    }

    /**
     * @param $activeDirectoryParams
     * @param $user
     * @return array
     */
    public function findUser($activeDirectoryParams, $user)
    {
        $ds = $this->connectAD($activeDirectoryParams);
        $dn = $activeDirectoryParams['ldapBaseDN'];
        $filter = 'samaccountname='.$user;
        $result = ldap_search($ds, $dn, $filter);
        return ldap_get_entries($ds, $result);
    }
}