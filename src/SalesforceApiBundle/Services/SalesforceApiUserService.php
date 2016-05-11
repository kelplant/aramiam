<?php
namespace SalesforceApiBundle\Services;

use CoreBundle\Entity\Admin\Utilisateur;
use CoreBundle\Services\Manager\Admin\UtilisateurManager;
use SalesforceApiBundle\Factory\SalesforceUserFactory;
use SalesforceApiBundle\Services\Manager\SalesforceUserLinkManager;
use Symfony\Component\HttpFoundation\Request;

class SalesforceApiUserService extends AbstractSalesforceApiService
{
    /**
     * @var SalesforceUserFactory
     */
    protected $salesforceUserFactory;

    /**
     * @var UtilisateurManager
     */
    protected $utilisateurManager;

    /**
     * @var SalesforceApiGroupesServices
     */
    protected $salesforceApiGroupesService;

    /**
     * @var SalesforceApiTerritoriesServices
     */
    protected $salesforceApiTerritoriesService;

    /**
     * @var SalesforceUserLinkManager
     */
    protected $salesforceUserLinkManager;

    /**
     * SalesforceApiUserService constructor.
     * @param SalesforceUserFactory $salesforceUserFactory
     * @param UtilisateurManager $utilisateurManager
     * @param SalesforceApiGroupesServices $salesforceApiGroupesService
     * @param SalesforceApiTerritoriesServices $salesforceApiTerritoriesService
     * @param SalesforceUserLinkManager $salesforceUserLinkManager
     */
    public function __construct(SalesforceUserFactory $salesforceUserFactory, UtilisateurManager $utilisateurManager, SalesforceApiGroupesServices $salesforceApiGroupesService, SalesforceApiTerritoriesServices $salesforceApiTerritoriesService, SalesforceUserLinkManager $salesforceUserLinkManager)
    {
        $this->salesforceUserFactory           = $salesforceUserFactory;
        $this->utilisateurManager              = $utilisateurManager;
        $this->salesforceApiGroupesService     = $salesforceApiGroupesService;
        $this->salesforceApiTerritoriesService = $salesforceApiTerritoriesService;
        $this->salesforceUserLinkManager       = $salesforceUserLinkManager;
    }

    /**
     * @param $params
     * @param string $newSalesforceUser
     * @return array|string
     */
    public function createNewUser($params, $newSalesforceUser)
    {
        return $this->executeQuery('/sobjects/User/', $params, $newSalesforceUser, "POST");
    }

    /**
     * @param $params
     * @param $newSalesforceUser
     * @param $salesforceId
     * @return array|string
     */
    public function updateUser($params, $newSalesforceUser, $salesforceId)
    {
        return $this->executeQuery('/sobjects/User/'.$salesforceId, $params, $newSalesforceUser, "PATCH");
    }

    /**
     * @param $emailToLook
     * @param $params
     * @return string
     */
    public function getAccountByUsername($emailToLook, $params)
    {
        $query = "SELECT Id,Username,CallCenterId FROM User WHERE Username = '".$emailToLook."'";
        return $this->executeQuery('/query?q='.urlencode($query), $params, null, "GET");
    }

    /**
     * @param $emailToLook
     * @param $params
     * @return array|string
     */
    public function getAllInfosForAccountByUsername($emailToLook, $params)
    {
        return $this->executeQuery('/sobjects/User/Username/'.$emailToLook, $params, null, "GET");
    }

    /**
     * @param $userId
     * @return Utilisateur|null
     */
    private function loadAUser($userId) {
        return $this->utilisateurManager->load($userId);
    }

    /**
     * @param $sendaction
     * @param Request $request
     * @param $params
     */
    public function ifSalesforceCreate($sendaction, Request $request, $params)
    {
        if ($sendaction == "Créer sur Salesforce") {
            $utilisateurInfos = $this->loadAUser($request->request->get('utilisateur')['id']);
            $newSalesforceUser = $this->salesforceUserFactory->prepareSalesforceUserFromBDD($request, $utilisateurInfos);
            try {
                $this->createNewUser($params, json_encode($newSalesforceUser));
                $this->utilisateurManager->appendSessionMessaging(array('errorCode' => '0', 'message' => 'L\'Utilisateur '.$utilisateurInfos->getEmail().' a été créé dans Salesforce'));
            } catch (\Exception $e) {
                $this->utilisateurManager->appendSessionMessaging(array('errorCode' => error_log($e->getMessage()), 'message' => $e->getMessage()));
            }
            $salesforceUser = json_decode($this->getAllInfosForAccountByUsername($utilisateurInfos->getEmail(), $params));
            $this->utilisateurManager->edit($request->request->get('utilisateur')['id'], array('isCreateInSalesforce' => $salesforceUser->Id));
            $this->salesforceUserLinkManager->add(array('id' => $salesforceUser->Id, 'user' => $request->request->get('utilisateur')['id'], 'salesforceProfil' => $request->request->get('salesforce')['profile']));
            $this->salesforceApiGroupesService->addGroupesForNewUser($salesforceUser->Id, $utilisateurInfos->getFonction(), $params);
            $this->salesforceApiTerritoriesService->addTerritoriesForNewUser($salesforceUser->Id, $utilisateurInfos->getService(), $params);
        }
    }

    /**
     * @param $tabToSend
     * @param $params
     */
    public function ifUserUpdated($tabToSend, $params)
    {
        $userInfos = $this->utilisateurManager->load($tabToSend['utilisateurId']);
        $salesforceUserInfos = $this->salesforceUserLinkManager->load($userInfos->getIsCreateInSalesforce());
        $newSalesforceUser = $this->salesforceUserFactory->prepareSalesforceUserFromRequest($tabToSend, $salesforceUserInfos);
        try {
            $this->updateUser($params, json_encode($newSalesforceUser), $userInfos->getIsCreateInSalesforce());
            $this->utilisateurManager->appendSessionMessaging(array('errorCode' => '0', 'message' => 'L\'Utilisateur '.$tabToSend['newDatas']['mail'].' a été mis à jour dans Salesforce'));
        } catch (\Exception $e) {
            $this->utilisateurManager->appendSessionMessaging(array('errorCode' => error_log($e->getMessage()), 'message' => $e->getMessage()));
        }
        //$salesforceUserId = json_decode($this->getAccountByUsername($request->request->get('utilisateur')['email'], $params))->records[0]->Id;
        //$this->salesforceApiGroupesService->addGroupesForNewUser($salesforceUserId, $request->request->get('utilisateur')['fonction'], $params);
        //$this->salesforceApiTerritoriesService->addTerritoriesForNewUser($salesforceUserId, $request->request->get('utilisateur')['service'], $params);

    }

}