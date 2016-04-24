<?php
namespace SalesforceApiBundle\Services;

use SalesforceApiBundle\Services\Manager\SalesforceTerritoryMatchServiceManager;
use SalesforceApiBundle\Services\Manager\SalesforceGroupeManager;

class SalesforceApiTerritoriesServices
{
    protected $salesforceApiService;

    protected $SalesforceTerritoryMatchService;

    protected $salesforceTerritoriesManager;

    /**
     * SalesforceGroupesServices constructor.
     * @param SalesforceApiService $salesforceApiService
     * @param SalesforceTerritoryMatchServiceManager $SalesforceTerritoryMatchService
     * @param SalesforceGroupeManager $salesforceTerritoriesManager
     */
    public function __construct($salesforceApiService, $SalesforceTerritoryMatchService, $salesforceTerritoriesManager)
    {
        $this->salesforceApiService = $salesforceApiService;
        $this->SalesforceTerritoryMatchService = $SalesforceTerritoryMatchService;
        $this->salesforceTerritoriesManager = $salesforceTerritoriesManager;
    }

    public function addGroupesForNewUser()
    {
        //var_dump($this->SalesforceGroupeMatchFonction->getRepository()->findBy(array('fonctionId' => $request->request->get('utilisateur')['fonction']), array('fonctionId' => 'ASC')));
    }
}