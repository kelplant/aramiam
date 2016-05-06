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
    protected $SalesforceTerritoryMatchService;

    /**
     * @var SalesforceGroupeManager
     */
    protected $salesforceTerritoriesManager;

    /**
     * SalesforceApiTerritoriesServices constructor.
     * @param SalesforceApiService $salesforceApiService
     * @param SalesforceUserTerritoryFactory $salesforceUserTerritoryFactory
     * @param SalesforceTerritoryMatchServiceManager $SalesforceTerritoryMatchService
     * @param SalesforceGroupeManager $salesforceTerritoriesManager
     */
    public function __construct(SalesforceApiService $salesforceApiService, SalesforceUserTerritoryFactory $salesforceUserTerritoryFactory, SalesforceTerritoryMatchServiceManager $SalesforceTerritoryMatchService, SalesforceGroupeManager $salesforceTerritoriesManager)
    {
        $this->salesforceApiService            = $salesforceApiService;
        $this->salesforceUserTerritoryFactory  = $salesforceUserTerritoryFactory;
        $this->SalesforceTerritoryMatchService = $SalesforceTerritoryMatchService;
        $this->salesforceTerritoriesManager    = $salesforceTerritoriesManager;
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
            $itemToAdd = $this->salesforceUserTerritoryFactory->createFromEntity(array('TerritoryId' => $this->salesforceTerritoriesManager->load($groupe->getSalesforceTerritory())->getTerritoryId(), 'UserId' => $userId, 'IsActive' => true));
            return $this->salesforceApiService->addUserToTerritory($params, json_encode($itemToAdd));
        }
    }
}