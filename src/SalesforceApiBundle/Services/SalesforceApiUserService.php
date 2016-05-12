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
     * @param string $newSalesforceUser
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
     * @return string
     */
    public function getAllInfosForAccountByUsername($emailToLook, $params)
    {
        return $this->executeQuery('/sobjects/User/Username/'.$emailToLook, $params, null, "GET");
    }

    /**
     * @param $userId
     * @return Utilisateur|null
     */
    private function loadUser($userId) {
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
            $utilisateurInfos = $this->loadUser($request->request->get('utilisateur')['id']);
            $newSalesforceUser = $this->salesforceUserFactory->prepareSalesforceUserFromBDD($request, $utilisateurInfos, $request->request->get('salesforce')['profile']);
            $newSalesforceUser->setIsActive(true);
            try {
                $this->createNewUser($params, json_encode($newSalesforceUser));
                $this->utilisateurManager->appendSessionMessaging(array('errorCode' => '0', 'message' => 'L\'Utilisateur '.$utilisateurInfos->getEmail().' a été créé dans Salesforce'));
                $salesforceUser = json_decode($this->getAllInfosForAccountByUsername($utilisateurInfos->getEmail(), $params));
                $this->utilisateurManager->edit($request->request->get('utilisateur')['id'], array('isCreateInSalesforce' => $salesforceUser->Id));
                $this->salesforceUserLinkManager->add(array('id' => $salesforceUser->Id, 'user' => $request->request->get('utilisateur')['id'], 'salesforceProfil' => $request->request->get('salesforce')['profile']));
                $this->salesforceApiGroupesService->addGroupesForNewUser($salesforceUser->Id, $utilisateurInfos->getFonction(), $params);
                $this->salesforceApiTerritoriesService->addTerritoriesForNewUser($salesforceUser->Id, $utilisateurInfos->getService(), $params);
            } catch (\Exception $e) {
                $this->utilisateurManager->appendSessionMessaging(array('errorCode' => error_log($e->getMessage()), 'message' => $e->getMessage()));
            }
        }
    }

    /**
     * @param $sendaction
     * @param Request $request
     * @param $params
     */
    public function ifSalesforceProfilUpdated($sendaction, Request $request, $params)
    {
        if ($sendaction == "Mettre à jour sur Salesforce") {
            $utilisateurInfos = $this->loadUser($request->request->get('utilisateur')['id']);
            $newSalesforceUser = $this->salesforceUserFactory->prepareSalesforceUserFromBDD($request, $utilisateurInfos, $request->request->get('salesforce')['profile']);
            $newSalesforceUser->setIsActive(true);
            try {
                $this->updateUser($params, json_encode($newSalesforceUser), $utilisateurInfos->getIsCreateInSalesforce());
                $this->utilisateurManager->appendSessionMessaging(array('errorCode' => '0', 'message' => 'Le profil salesforce de '.$utilisateurInfos->getEmail().' a été mis à jour'));
                $this->salesforceUserLinkManager->edit($utilisateurInfos->getIsCreateInSalesforce(), array('salesforceProfil' => $request->request->get('salesforce')['profile']));
            } catch (\Exception $e) {
                $this->utilisateurManager->appendSessionMessaging(array('errorCode' => error_log($e->getMessage()), 'message' => $e->getMessage()));
            }
        }
    }

    /**
     * @param $tabToSend
     * @param $params
     */
    public function ifUserUpdated($tabToSend, $params)
    {
        $utilisateurInfos = $this->loadUser($tabToSend['utilisateurId']);
        $salesforceUserInfos = $this->salesforceUserLinkManager->load($utilisateurInfos->getIsCreateInSalesforce());
        $newSalesforceUser = $this->salesforceUserFactory->prepareSalesforceUserFromRequest($tabToSend, $salesforceUserInfos);
        $newSalesforceUser->setIsActive(true);
        try {
            $this->updateUser($params, json_encode($newSalesforceUser), $utilisateurInfos->getIsCreateInSalesforce());
            $this->utilisateurManager->appendSessionMessaging(array('errorCode' => '0', 'message' => 'L\'Utilisateur '.$tabToSend['newDatas']['mail'].' a été mis à jour dans Salesforce'));
        } catch (\Exception $e) {
            $this->utilisateurManager->appendSessionMessaging(array('errorCode' => error_log($e->getMessage()), 'message' => $e->getMessage()));
        }
        if ($tabToSend['utilisateurFonction'] != $tabToSend['utilisateurOldFonction']) {
            $this->salesforceApiGroupesService->deleteGroupesForUser($utilisateurInfos->getIsCreateInSalesforce(), $tabToSend['utilisateurOldFonction'], $params);
            $this->salesforceApiGroupesService->addGroupesForNewUser($utilisateurInfos->getIsCreateInSalesforce(), $tabToSend['utilisateurFonction'], $params);
        }
        if ($tabToSend['utilisateurService'] != $tabToSend['utilisateurOldService']) {
            $this->salesforceApiTerritoriesService->removeTerritoriesForUser($utilisateurInfos->getIsCreateInSalesforce(), $tabToSend['utilisateurOldService'], $params);
            $this->salesforceApiTerritoriesService->addTerritoriesForNewUser($utilisateurInfos->getIsCreateInSalesforce(), $tabToSend['utilisateurService'], $params);
        }
    }

    /**
     * @param $sendaction
     * @param Request $request
     * @param $params
     */
    public function IfSalesforceDesactivateAccount($sendaction, Request $request, $params)
    {
        if ($sendaction == "Désactiver") {
            $this->ActiveDesactiveSalesforceAccount($request, $params, false);
        }
    }

    /**
     * @param $sendaction
     * @param Request $request
     * @param $params
     */
    public function IfSalesforceActivateAccount($sendaction, Request $request, $params)
    {
        if ($sendaction == "Activer") {
            $this->ActiveDesactiveSalesforceAccount($request, $params, true);
            $utilisateurInfos = $this->loadUser($request->request->get('utilisateur')['id']);
            $this->salesforceApiTerritoriesService->addTerritoriesForNewUser($utilisateurInfos->getIsCreateInSalesforce(), $request->request->get('utilisateur')['service'], $params);
        }
    }
    /**
     * @param Request $request
     * @param $params
     * @param boolean $state
     */
    public function ActiveDesactiveSalesforceAccount(Request $request, $params, $state)
    {
        $utilisateurInfos = $this->loadUser($request->request->get('utilisateur')['id']);
        $salesforceUserInfos = $this->salesforceUserLinkManager->load($utilisateurInfos->getIsCreateInSalesforce());
        $tabToSend = array('utilisateurId' => $request->request->get('utilisateur')['id'], 'newDatas' => array('givenName' => $request->request->get('utilisateur')['surname'], 'displayName' => $request->request->get('utilisateur')['viewName'], 'sn' => $request->request->get('utilisateur')['name'], 'mail' => $request->request->get('utilisateur')['email']), 'utilisateurService' => $request->request->get('utilisateur')['service'], 'utilisateurFonction' => $request->request->get('utilisateur')['fonction'], 'utilisateurOldService' => $request->request->get('utilisateur')['service'], 'utilisateurOldFonction' => $request->request->get('utilisateur')['fonction'], 'utilisateurOldEmail' => $request->request->get('utilisateur')['email'], 'request' => $request);
        $newSalesforceUser = $this->salesforceUserFactory->prepareSalesforceUserFromRequest($tabToSend, $salesforceUserInfos);
        $newSalesforceUser->setIsActive($state);
        try {
            $this->updateUser($params, json_encode($newSalesforceUser), $utilisateurInfos->getIsCreateInSalesforce());
            $this->utilisateurManager->appendSessionMessaging(array('errorCode' => '0', 'message' => 'L\'Utilisateur '.$tabToSend['newDatas']['mail'].' a été désactiver dans Salesforce'));
        } catch (\Exception $e) {
            $this->utilisateurManager->appendSessionMessaging(array('errorCode' => error_log($e->getMessage()), 'message' => $e->getMessage()));
        }
    }
}