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
class SalesforceApiTerritoriesServices
{
    /**
     * @var SalesforceApiService
     */
    protected $salesforceApiService;

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
     * @param SalesforceApiService $salesforceApiService
     * @param SalesforceUserTerritoryFactory $salesforceUserTerritoryFactory
     * @param SalesforceTerritoryMatchServiceManager $SalesforceTerritoryMatchServiceManager
     * @param SalesforceTerritoryManager $salesforceTerritoriyManager
     */
    public function __construct(SalesforceApiService $salesforceApiService, SalesforceUserTerritoryFactory $salesforceUserTerritoryFactory, SalesforceTerritoryMatchServiceManager $SalesforceTerritoryMatchServiceManager, SalesforceTerritoryManager $salesforceTerritoriyManager)
    {
        $this->salesforceApiService = $salesforceApiService;
        $this->salesforceUserTerritoryFactory = $salesforceUserTerritoryFactory;
        $this->SalesforceTerritoryMatchServiceManager = $SalesforceTerritoryMatchServiceManager;
        $this->salesforceTerritoriyManager = $salesforceTerritoriyManager;
    }

    /**
     * @param $userId
     * @param $fonctionId
     * @param $params
     * @return array|string
     */
    public function addTerritoriesForNewUser($userId, $fonctionId, $params)
    {
        foreach ($this->SalesforceTerritoryMatchServiceManager->getRepository()->findBy(array('serviceId' => $fonctionId), array('serviceId' => 'ASC')) as $groupe) {
            $itemToAdd = $this->salesforceUserTerritoryFactory->createFromEntity(array('TerritoryId' => $this->salesforceTerritoriyManager->load($groupe->getSalesforceTerritory())->getTerritoryId(), 'UserId' => $userId, 'IsActive' => true));
            return $this->salesforceApiService->addUserToTerritory($params, json_encode($itemToAdd));
        }
    }
}