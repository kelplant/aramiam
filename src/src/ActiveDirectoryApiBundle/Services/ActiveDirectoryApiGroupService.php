<?php
namespace ActiveDirectoryApiBundle\Services;

/**
 * Class ActiveDirectoryApiGroupService
 * @package ActiveDirectoryApiBundle\Services
 */
class ActiveDirectoryApiGroupService extends AbstractActiveDirectoryApiService
{
    /**
     * @param resource $ds
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
     * @param resource $ds
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
     * @param string $action
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
     * @param $tabToSend
     * @param $activeDirectoryParams
     * @param string $newcn
     */
    public function progagateInActiveDirectoryIfServiceOrFonctionModified($tabToSend, $activeDirectoryParams, $newcn)
    {
        if ($tabToSend['utilisateurOldService'] != $tabToSend['utilisateurService'] || $tabToSend['utilisateurOldFonction'] != $tabToSend['utilisateurFonction']) {
            $this->parseServiceAndFonctionAndDoAction($activeDirectoryParams, $tabToSend['utilisateurOldService'], $tabToSend['utilisateurOldFonction'], $newcn, 'remove');
            $this->parseServiceAndFonctionAndDoAction($activeDirectoryParams, $tabToSend['utilisateurService'], $tabToSend['utilisateurFonction'], $newcn, 'add');
        }
    }
}