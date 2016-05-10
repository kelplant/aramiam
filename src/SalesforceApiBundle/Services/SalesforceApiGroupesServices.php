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
     * @return mixed
     */
    public function getListOfGroupes($params)
    {
        $query = "SELECT Id,Name FROM Group ORDER BY Name ASC NULLS LAST";
        return $this->executeQuery('/query?q='.urlencode($query), $params, null, "GET");
    }

    /**
     * @param $userId
     * @param $fonctionId
     * @param $params
     */
    public function addGroupesForNewUser($userId, $fonctionId, $params)
    {
        $listOfGroupes = $this->SalesforceGroupeMatchFonction->getRepository()->findBy(array('fonctionId' => $fonctionId), array('fonctionId' => 'ASC'));
        foreach ($listOfGroupes as $groupe) {
            $itemToAdd = $this->salesforceGroupMemberFactory->createFromEntity(array('GroupId' => $this->salesforceGroupesManager->load($groupe->getSalesforceGroupe())->getGroupeId(), 'UserOrGroupId' => $userId));
            try {
                $this->addUserToGroupe($params, json_encode($itemToAdd));
                $this->salesforceGroupesManager->appendSessionMessaging(array('errorCode' => '0', 'message' => 'L\'Utilisateur '.$userId.' a été créé ajouté au groupe'.$groupe->getGroupeName()));
            } catch (\Exception $e) {
                $this->salesforceGroupesManager->appendSessionMessaging(array('errorCode' => error_log($e->getMessage()), 'message' => $e->getMessage()));
            }
        }
    }
}