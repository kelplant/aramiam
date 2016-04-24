<?php
namespace SalesforceApiBundle\Services;

use SalesforceApiBundle\Services\Manager\SalesforceGroupeMatchFonctionManager;
use SalesforceApiBundle\Services\Manager\SalesforceGroupeManager;

class SalesforceApiGroupesServices
{
    protected $salesforceApiService;

    protected $SalesforceGroupeMatchFonction;

    protected $salesforceGroupesManager;

    /**
     * SalesforceGroupesServices constructor.
     * @param SalesforceApiService $salesforceApiService
     * @param SalesforceGroupeMatchFonctionManager $SalesforceGroupeMatchFonction
     * @param SalesforceGroupeManager $salesforceGroupesManager
     */
    public function __construct($salesforceApiService, $SalesforceGroupeMatchFonction, $salesforceGroupesManager)
    {
        $this->salesforceApiService = $salesforceApiService;
        $this->SalesforceGroupeMatchFonction = $SalesforceGroupeMatchFonction;
        $this->salesforceGroupesManager = $salesforceGroupesManager;
    }

    public function addGroupesForNewUser($userId, $fonctionId)
    {
        var_dump($this->SalesforceGroupeMatchFonction->getRepository()->findBy(array('fonctionId' => $fonctionId), array('fonctionId' => 'ASC')));
    }
}