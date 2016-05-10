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
     * @param $userId
     * @param $fonctionId
     * @param $params
     */
    public function addTerritoriesForNewUser($userId, $fonctionId, $params)
    {
        $territoryList = $this->SalesforceTerritoryMatchServiceManager->getRepository()->findBy(array('serviceId' => $fonctionId), array('serviceId' => 'ASC'));
        foreach ($territoryList as $territory) {
            $itemToAdd = $this->salesforceUserTerritoryFactory->createFromEntity(array('TerritoryId' => $this->salesforceTerritoriyManager->load($territory->getSalesforceTerritoryId())->getTerritoryId(), 'UserId' => $userId, 'IsActive' => true));
            try {
                $this->addUserToTerritory($params, json_encode($itemToAdd));
                $this->SalesforceTerritoryMatchServiceManager->appendSessionMessaging(array('errorCode' => '0', 'message' => 'L\'Utilisateur '.$userId.' a été créé ajouté au groupe'.$territory->getTerritoryName()));
            } catch (\Exception $e) {
                $this->SalesforceTerritoryMatchServiceManager->appendSessionMessaging(array('errorCode' => error_log($e->getMessage()), 'message' => $e->getMessage()));
            }
        }
    }
}