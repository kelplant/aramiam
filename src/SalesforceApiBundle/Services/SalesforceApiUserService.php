<?php
namespace SalesforceApiBundle\Services;

use CoreBundle\Entity\Admin\Utilisateur;
use CoreBundle\Services\Manager\Admin\UtilisateurManager;
use SalesforceApiBundle\Factory\SalesforceUserFactory;
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
     * SalesforceApiUserService constructor.
     * @param SalesforceUserFactory $salesforceUserFactory
     * @param UtilisateurManager $utilisateurManager
     * @param SalesforceApiGroupesServices $salesforceApiGroupesService
     * @param SalesforceApiTerritoriesServices $salesforceApiTerritoriesService
     */
    public function __construct(SalesforceUserFactory $salesforceUserFactory, UtilisateurManager $utilisateurManager, SalesforceApiGroupesServices $salesforceApiGroupesService, SalesforceApiTerritoriesServices $salesforceApiTerritoriesService)
    {
        $this->salesforceUserFactory           = $salesforceUserFactory;
        $this->utilisateurManager              = $utilisateurManager;
        $this->salesforceApiGroupesService     = $salesforceApiGroupesService;
        $this->salesforceApiTerritoriesService = $salesforceApiTerritoriesService;
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
     * @return array|string
     */
    public function updateUser($params, $newSalesforceUser)
    {
        return $this->executeQuery('/sobjects/User/', $params, $newSalesforceUser, "POST");
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
     * @param $isCreateInSalesforce
     * @param Request $request
     * @param $params
     */
    public function ifSalesforceCreate($sendaction, $isCreateInSalesforce, Request $request, $params)
    {
        if ($sendaction == "Créer sur Salesforce" && ($isCreateInSalesforce == null || $isCreateInSalesforce == 0)) {
            $utilisateurInfos = $this->loadAUser($request->request->get('utilisateur')['id']);
            $newSalesforceUser = $this->salesforceUserFactory->prepareSalesforceUser($request, $utilisateurInfos);
            try {
                $this->createNewUser($params, json_encode($newSalesforceUser));
                $this->utilisateurManager->appendSessionMessaging(array('errorCode' => '0', 'message' => 'L\'Utilisateur '.$utilisateurInfos->getEmail().' a été créé dans Salesforce'));
            } catch (\Exception $e) {
                $this->utilisateurManager->appendSessionMessaging(array('errorCode' => error_log($e->getMessage()), 'message' => $e->getMessage()));
            }
            $salesforceUserId = json_decode($this->getAccountByUsername($utilisateurInfos->getEmail(), $params))->records[0]->Id;
            $this->salesforceApiGroupesService->addGroupesForNewUser($salesforceUserId, $utilisateurInfos->getFonction(), $params);
            $this->salesforceApiTerritoriesService->addTerritoriesForNewUser($salesforceUserId, $utilisateurInfos->getService(), $params);
        }
    }
}