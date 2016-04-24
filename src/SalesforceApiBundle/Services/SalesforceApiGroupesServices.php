<?php
namespace SalesforceApiBundle\Services;

use SalesforceApiBundle\Factory\SalesforceGroupMemberFactory;
use SalesforceApiBundle\Services\Manager\SalesforceGroupeMatchFonctionManager;
use SalesforceApiBundle\Services\Manager\SalesforceGroupeManager;

/**
 * Class SalesforceApiGroupesServices
 * @package SalesforceApiBundle\Services
 */
class SalesforceApiGroupesServices
{
    protected $salesforceApiService;

    protected $salesforceGroupMemberFactory;

    protected $SalesforceGroupeMatchFonction;

    protected $salesforceGroupesManager;

    /**
     * SalesforceGroupesServices constructor.
     * @param SalesforceApiService $salesforceApiService
     * @param SalesforceGroupMemberFactory $salesforceGroupMemberFactory
     * @param SalesforceGroupeMatchFonctionManager $SalesforceGroupeMatchFonction
     * @param SalesforceGroupeManager $salesforceGroupesManager
     */
    public function __construct($salesforceApiService, $salesforceGroupMemberFactory, $SalesforceGroupeMatchFonction, $salesforceGroupesManager)
    {
        $this->salesforceApiService = $salesforceApiService;
        $this->salesforceGroupMemberFactory = $salesforceGroupMemberFactory;
        $this->SalesforceGroupeMatchFonction = $SalesforceGroupeMatchFonction;
        $this->salesforceGroupesManager = $salesforceGroupesManager;
    }

    /**
     * @param $userId
     * @param $fonctionId
     * @param $params
     * @return array|string
     */
    public function addGroupesForNewUser($userId, $fonctionId, $params)
    {
        foreach ($this->SalesforceGroupeMatchFonction->getRepository()->findBy(array('fonctionId' => $fonctionId), array('fonctionId' => 'ASC')) as $groupe) {
            $itemToAdd = $this->salesforceGroupMemberFactory->createFromEntity(array ('GroupId' => $this->salesforceGroupesManager->load($groupe->getSalesforceGroupe())->getGroupeId(), 'UserOrGroupId' => $userId));
            return $this->salesforceApiService->addUserToGroupe($params, json_encode($itemToAdd));
        }
    }
}