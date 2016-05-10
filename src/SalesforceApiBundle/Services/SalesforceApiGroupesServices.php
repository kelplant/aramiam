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
    /**
     * @var SalesforceApiService
     */
    protected $salesforceApiService;

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
     * @param SalesforceApiService $salesforceApiService
     * @param SalesforceGroupMemberFactory $salesforceGroupMemberFactory
     * @param SalesforceGroupeMatchFonctionManager $SalesforceGroupeMatchFonction
     * @param SalesforceGroupeManager $salesforceGroupesManager
     */
    public function __construct(SalesforceApiService $salesforceApiService, SalesforceGroupMemberFactory $salesforceGroupMemberFactory, SalesforceGroupeMatchFonctionManager $SalesforceGroupeMatchFonction, SalesforceGroupeManager $salesforceGroupesManager)
    {
        $this->salesforceApiService          = $salesforceApiService;
        $this->salesforceGroupMemberFactory  = $salesforceGroupMemberFactory;
        $this->SalesforceGroupeMatchFonction = $SalesforceGroupeMatchFonction;
        $this->salesforceGroupesManager      = $salesforceGroupesManager;
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
                $this->salesforceApiService->addUserToGroupe($params, json_encode($itemToAdd));
                $this->salesforceGroupesManager->appendSessionMessaging(array('errorCode' => '0', 'message' => 'L\'Utilisateur '.$userId.' a été créé ajouté au groupe'.$groupe->getGroupeName()));
            } catch (\Exception $e) {
                $this->salesforceGroupesManager->appendSessionMessaging(array('errorCode' => error_log($e->getMessage()), 'message' => $e->getMessage()));
            }
        }
    }
}