<?php
namespace SalesforceApiBundle\Services;

use SalesforceApiBundle\Factory\SalesforceUserTerritoryFactory;
use SalesforceApiBundle\Services\Manager\SalesforceTerritoryManager;
use SalesforceApiBundle\Services\Manager\SalesforceTerritoryMatchServiceManager;
use SalesforceApiBundle\Services\Manager\SalesforceGroupeManager;

/**
 * Class SalesforceApiTerritoriesServices
 * @package SalesforceApiBundle\Services
 */
class SalesforceApiTerritoriesServices extends AbstractSalesforceApiService
{
    /**
     * @var SalesforceUserTerritoryFactory
     */
    protected $salesforceUserTerritoryFactory;

    /**
     * @var SalesforceTerritoryMatchServiceManager
     */
    protected $SalesforceTerritoryMatchServiceManager;

    /**
     * @var SalesforceTerritoryManager
     */
    protected $salesforceTerritoriyManager;

    /**
     * SalesforceGroupesServices constructor.
     * @param SalesforceUserTerritoryFactory $salesforceUserTerritoryFactory
     * @param SalesforceTerritoryMatchServiceManager $SalesforceTerritoryMatchServiceManager
     * @param SalesforceTerritoryManager $salesforceTerritoriyManager
     */
    public function __construct(SalesforceUserTerritoryFactory $salesforceUserTerritoryFactory, SalesforceTerritoryMatchServiceManager $SalesforceTerritoryMatchServiceManager, SalesforceTerritoryManager $salesforceTerritoriyManager)
    {
        $this->salesforceUserTerritoryFactory = $salesforceUserTerritoryFactory;
        $this->SalesforceTerritoryMatchServiceManager = $SalesforceTerritoryMatchServiceManager;
        $this->salesforceTerritoriyManager = $salesforceTerritoriyManager;
    }

    /**
     * @param $params
     * @param $userInTerritoryToAdd
     * @return array|string
     */
    public function addUserToTerritory($params, $userInTerritoryToAdd)
    {
        return $this->executeQuery('/sobjects/UserTerritory', $params, $userInTerritoryToAdd, "POST");
    }

    /**
     * @param $params
     * @return mixed
     */
    public function getListOfTerritories($params)
    {
        $query = "SELECT Id,Name,ParentTerritoryId FROM Territory ORDER BY Name ASC NULLS LAST";
        return $this->executeQuery('/query?q='.urlencode($query), $params, null, "GET");
    }

    /**
     * @param $params
     * @param $userId
     * @param $groupId
     * @return array|string
     */
    public function getTheTerritoryId($params, $userId, $groupId)
    {
        $query = "SELECT Id FROM UserTerritory WHERE UserId='".$userId."' AND TerritoryId='".$groupId."' AND IsActive = true";
        return $this->executeQuery('/query?q='.urlencode($query), $params, null, "GET");
    }

    /**
     * @param $params
     * @param $userId
     * @return array|string
     */
    public function getListOfTerritoriesForUser($params, $userId)
    {
        $query = "SELECT Id,TerritoryId FROM UserTerritory WHERE UserId = '".$userId."' AND IsActive = true";
        return $this->executeQuery('/query?q='.urlencode($query), $params, null, "GET");
    }

    /**
     * @param $params
     * @param $territoryMemberId
     * @return array|string
     */
    public function deleteUserInTerritory($params, $territoryMemberId)
    {
        return $this->executeQuery('/sobjects/UserTerritory/'.$territoryMemberId, $params, null, "DELETE");
    }

    /**
     * @param $serviceId
     * @return array
     */
    public function listOfTerritoriesForService($serviceId)
    {
        return $this->SalesforceTerritoryMatchServiceManager->getRepository()->findBy(array('serviceId' => $serviceId), array('serviceId' => 'ASC'));
    }

    /**
     * @param $userId
     * @param $serviceId
     * @param $params
     */
    public function addTerritoriesForNewUser($userId, $serviceId, $params)
    {
        $listOfTerritories = $this->SalesforceTerritoryMatchServiceManager->getRepository()->findBy(array('serviceId' => $serviceId), array('serviceId' => 'ASC'));
        foreach ($listOfTerritories as $territory) {
            $territoryInfos = $this->salesforceTerritoriyManager->load($territory->getSalesforceTerritoryId());
            $itemToAdd = $this->salesforceUserTerritoryFactory->createFromEntity(array('TerritoryId' => $territoryInfos->getTerritoryId(), 'UserId' => $userId));
            try {
                $this->addUserToTerritory($params, json_encode($itemToAdd));
                $this->SalesforceTerritoryMatchServiceManager->appendSessionMessaging(array('errorCode' => '0', 'message' => 'L\'Utilisateur a été créé ajouté au territoire '.$territoryInfos->getTerritoryName()));
            } catch (\Exception $e) {
                $this->SalesforceTerritoryMatchServiceManager->appendSessionMessaging(array('errorCode' => error_log($e->getMessage()), 'message' => $e->getMessage()));
            }
        }
    }

    /**
     * @param $salesforceUserId
     * @param $serviceId
     * @param $params
     */
    public function removeTerritoriesForUser($salesforceUserId, $serviceId, $params)
    {
        $listOfTerritories = $this->listOfTerritoriesForService($serviceId);
        foreach ($listOfTerritories as $territory) {
            $salesforceTerritoryMember = json_decode($this->getTheTerritoryId($params, $salesforceUserId, $territory->getSalesforceTerritoryId()));
            $territoryInfos = $this->salesforceTerritoriyManager->load($territory->getSalesforceTerritoryId());
            try {
                $this->deleteUserInTerritory($params, $salesforceTerritoryMember->records[0]->Id);
                $this->SalesforceTerritoryMatchServiceManager->appendSessionMessaging(array('errorCode' => '0', 'message' => 'L\'Utilisateur a été supprimé du territoire '.$territoryInfos->getTerritoryName()));
            } catch (\Exception $e) {
                $this->SalesforceTerritoryMatchServiceManager->appendSessionMessaging(array('errorCode' => error_log($e->getMessage()), 'message' => $e->getMessage()));
            }
        }
    }
}