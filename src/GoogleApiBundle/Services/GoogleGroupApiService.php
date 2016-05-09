<?php
namespace GoogleApiBundle\Services;

use Exception;

/**
 * Class GoogleGroupApiService
 * @package GoogleApiBundle\Services
 */
class GoogleGroupApiService extends AbstractGoogleApiService
{
    /**
     * @param $action
     * @param $service
     * @param $value
     * @param $member
     */
    private function switchAddOrRemoveUserToGroups($action,  $service, $value, $member, $user)
    {
        if ($action == 'ajouté') {
            $service->members->insert($value, $member);
        }
        if ($action == 'supprimé') {
            $service->members->delete($value, $user);
        }
    }

    /**
     * @param $params
     * @param $user
     * @param $listOfGroupsEmails
     */
    public function addOrDeleteUserFromGroups($params, $user, $listOfGroupsEmails, $action)
    {
        $service = $this->innitApi($params);
        $member  = new \Google_Service_Directory_Member();
        $member->setEmail($user);
        $member->setRole('MEMBER');
        foreach ($listOfGroupsEmails as $key => $value) {
            try {
                $this->switchAddOrRemoveUserToGroups($action, $service, $value, $member, $user);
                $this->utilisateurManager->appendSessionMessaging(array('errorCode' => '0', 'message' => 'Le group '.$value.' a été '.$action.' correctement'));
            } catch (Exception $e) {
                $this->utilisateurManager->appendSessionMessaging(array('errorCode' => error_log($e->getMessage()), 'message' => $e->getMessage()));
            }
        }
    }

    /**
     * @param $params
     * @return \Google_Service_Directory_Groups
     */
    public function getListeOfGroupes($params)
    {
        $service = $this->innitApi($params);
        return $service->groups->listGroups(array('domain' => 'aramisauto.com'));
    }
}
