<?php
namespace SalesforceApiBundle\Services;

use SalesforceApiBundle\Factory\SalesforceGroupMemberFactory;
use SalesforceApiBundle\Services\Manager\SalesforceGroupeMatchFonctionManager;
use SalesforceApiBundle\Services\Manager\SalesforceGroupeManager;

/**
 * Class SalesforceApiGroupesServices
 * @package SalesforceApiBundle\Services
 */
class SalesforceApiGroupesServices extends AbstractSalesforceApiService
{
    /**
     * @var SalesforceGroupMemberFactory
     */
    protected $salesforceGroupMemberFactory;

    /**
     * @var SalesforceGroupeMatchFonctionManager
     */
    protected $SalesforceGroupeMatchFonction;

    /**
     * @var SalesforceGroupeManager
     */
    protected $salesforceGroupesManager;

    /**
     * SalesforceApiGroupesServices constructor.
     * @param SalesforceGroupMemberFactory $salesforceGroupMemberFactory
     * @param SalesforceGroupeMatchFonctionManager $SalesforceGroupeMatchFonction
     * @param SalesforceGroupeManager $salesforceGroupesManager
     */
    public function __construct(SalesforceGroupMemberFactory $salesforceGroupMemberFactory, SalesforceGroupeMatchFonctionManager $SalesforceGroupeMatchFonction, SalesforceGroupeManager $salesforceGroupesManager)
    {
        $this->salesforceGroupMemberFactory  = $salesforceGroupMemberFactory;
        $this->SalesforceGroupeMatchFonction = $SalesforceGroupeMatchFonction;
        $this->salesforceGroupesManager      = $salesforceGroupesManager;
    }

    /**
     * @param $params
     * @param $userInGroupeToAdd
     * @return array|string
     */
    public function addUserToGroupe($params, $userInGroupeToAdd)
    {
        return $this->executeQuery('/sobjects/GroupMember/', $params, $userInGroupeToAdd, "POST");
    }

    /**
     * @param $params
     * @param $groupMemberId
     * @return array|string
     */
    public function deleteUserFromGroupe($params, $groupMemberId)
    {
        return $this->executeQuery('/sobjects/GroupMember/'.$groupMemberId, $params, null, "DELETE");
    }

    /**
     * @param $params
     * @param $userId
     * @param $groupId
     * @return array|string
     */
    public function getTheGroupId($params, $userId, $groupId)
    {
        $query = "SELECT Id FROM GroupMember WHERE UserOrGroupId='".$userId."' AND GroupId='".$groupId."'";
        return $this->executeQuery('/query?q='.urlencode($query), $params, null, "GET");
    }

    /**
     * @param $params
     * @param $userId
     * @return array|string
     */
    public function getListOfGroupesForUser($params, $userId)
    {
        $query = "SELECT Id,GroupId FROM GroupMember WHERE UserOrGroupId='".$userId."'";
        return $this->executeQuery('/query?q='.urlencode($query), $params, null, "GET");
    }

    /**
     * @param $params
     * @return mixed
     */
    public function getListOfGroupes($params)
    {
        $query = "SELECT Id,Name FROM Group ORDER BY Name ASC NULLS LAST";
        return $this->executeQuery('/query?q='.urlencode($query), $params, null, "GET");
    }

    /**
     * @param $fonctionId
     * @return array
     */
    public function listOfGroupesForFonction($fonctionId)
    {
        return $this->SalesforceGroupeMatchFonction->getRepository()->findBy(array('fonctionId' => $fonctionId), array('fonctionId' => 'ASC'));
    }

    /**
     * @param $salesforceUserId
     * @param $fonctionId
     * @param $params
     */
    public function deleteGroupesForUser($salesforceUserId, $fonctionId, $params)
    {
        $listOfGroupes = $this->listOfGroupesForFonction($fonctionId);
        foreach ($listOfGroupes as $group) {
            $salesforceGroupMember = json_decode($this->getTheGroupId($params, $salesforceUserId, $group->getSalesforceGroupe()));
            $groupInfos = $this->salesforceGroupesManager->load($group->getSalesforceGroupe());
            try {
                $this->deleteUserFromGroupe($params, $salesforceGroupMember->records[0]->Id);
                $this->salesforceGroupesManager->appendSessionMessaging(array('errorCode' => '0', 'message' => 'L\'Utilisateur a été supprimé du groupe '.$groupInfos->getGroupeName()));
            } catch (\Exception $e) {
                $this->salesforceGroupesManager->appendSessionMessaging(array('errorCode' => error_log($e->getMessage()), 'message' => $e->getMessage()));
            }
        }
    }

    /**
     * @param $userId
     * @param $fonctionId
     * @param $params
     */
    public function addGroupesForNewUser($userId, $fonctionId, $params)
    {
        $listOfGroupes = $this->listOfGroupesForFonction($fonctionId);
        foreach ($listOfGroupes as $group) {
            $groupInfos = $this->salesforceGroupesManager->load($group->getSalesforceGroupe());
            $itemToAdd = $this->salesforceGroupMemberFactory->createFromEntity(array('GroupId' => $groupInfos->getGroupeId(), 'UserOrGroupId' => $userId));
            try {
                $this->addUserToGroupe($params, json_encode($itemToAdd));
                $this->salesforceGroupesManager->appendSessionMessaging(array('errorCode' => '0', 'message' => 'L\'Utilisateur a été créé ajouté au groupe '.$groupInfos->getGroupeName()));
            } catch (\Exception $e) {
                $this->salesforceGroupesManager->appendSessionMessaging(array('errorCode' => error_log($e->getMessage()), 'message' => $e->getMessage()));
            }
        }
    }
}