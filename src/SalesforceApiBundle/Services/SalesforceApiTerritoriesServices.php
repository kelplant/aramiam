<?php
namespace SalesforceApiBundle\Services;

use SalesforceApiBundle\Factory\SalesforceUserTerritoryFactory;
use SalesforceApiBundle\Services\Manager\SalesforceTerritoryMatchServiceManager;
use SalesforceApiBundle\Services\Manager\SalesforceGroupeManager;

/**
 * Class SalesforceApiTerritoriesServices
 * @package SalesforceApiBundle\Services
 */
class SalesforceApiTerritoriesServices
{
    protected $salesforceApiService;

    protected $salesforceUserTerritoryFactory;

    protected $SalesforceTerritoryMatchService;

    protected $salesforceTerritoriesManager;

    /**
     * SalesforceGroupesServices constructor.
     * @param SalesforceApiService $salesforceApiService
     * @param SalesforceUserTerritoryFactory $salesforceUserTerritoryFactory
     * @param SalesforceTerritoryMatchServiceManager $SalesforceTerritoryMatchService
     * @param SalesforceGroupeManager $salesforceTerritoriesManager
     */
    public function __construct($salesforceApiService, $salesforceUserTerritoryFactory, $SalesforceTerritoryMatchService, $salesforceTerritoriesManager)
    {
        $this->salesforceApiService = $salesforceApiService;
        $this->salesforceUserTerritoryFactory = $salesforceUserTerritoryFactory;
        $this->SalesforceTerritoryMatchService = $SalesforceTerritoryMatchService;
        $this->salesforceTerritoriesManager = $salesforceTerritoriesManager;
    }

    /**
     * @param $userId
     * @param $fonctionId
     * @param $params
     * @return array|string
     */
    public function addTerritoriesForNewUser($userId, $fonctionId, $params)
    {
        foreach ($this->SalesforceTerritoryMatchService->getRepository()->findBy(array('serviceId' => $fonctionId), array('serviceId' => 'ASC')) as $groupe) {
            $itemToAdd = $this->salesforceUserTerritoryFactory->createFromEntity(array ('TerritoryId' => $this->salesforceTerritoriesManager->load($groupe->getSalesforceTerritory())->getTerritoryId(), 'UserId' => $userId, 'IsActive' => true));
            return $this->salesforceApiService->addUserToTerritory($params, json_encode($itemToAdd));
        }
    }
}