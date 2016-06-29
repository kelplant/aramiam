<?php
namespace GoogleApiBundle\Services;

use Exception;
use Google_Service_Directory_User;
use Google_Service_Directory_UserName;

/**
 * Class GoogleUserApiService
 * @package GoogleApiBundle\Services
 */
class GoogleUserApiService extends AbstractGoogleApiService
{
    /**
     * @var string
     */
    private $pageToken;

    /**
     * @var GoogleGroupApiService;
     */
    public $googleGroupApiService;

    /**
     * @param $userToCreate
     * @param \Google_Service_Directory $service
     */
    private function ifUserNotExist($userToCreate, $service)
    {
        try {
            $this->createNewUserAccount($service, $userToCreate);
            $this->utilisateurManager->appendSessionMessaging(array('errorCode' => '0', 'message' => 'Le compte Gmail a été créé '));
        } catch (Exception $e) {
            $this->utilisateurManager->appendSessionMessaging(array('errorCode' => error_log($e->getMessage()), 'message' => $e->getMessage()));
        }
    }

    /**
     * @param $prenom
     * @param $nom
     * @param $email
     * @return Google_Service_Directory_User
     */
    private function initBaseUser($prenom, $nom, $email)
    {
        $user = new Google_Service_Directory_User();
        $name = new Google_Service_Directory_UserName();
        $name->setGivenName($prenom);
        $name->setFamilyName($nom);
        $user->setName($name);
        $user->setPrimaryEmail($email);

        return $user;
    }

    /**
     * @param $userToCreate
     * @return Google_Service_Directory_User
     */
    private function initUserAccount($userToCreate)
    {
        $user = $this->initBaseUser($userToCreate['prenom'], $userToCreate['nom'], $userToCreate['email']);
        $user->setHashFunction("SHA-1");
        $user->setPassword(hash("sha1", $userToCreate['password']));

        return $user;
    }

    /**
     * @param $userToCreate
     * @param $params
     */
    private function ifEmailNotExistCreateUser($userToCreate, $params)
    {
        $service = $this->innitApi($params);
        try {
            $isCreated = $this->getInfosFromEmail($service, $userToCreate['email'], $params);
        } catch (Exception $e) {
            $isCreated = null;
        }
        if ($isCreated == null) {
            $this->ifUserNotExist($userToCreate, $service);
        }
    }

    /**
     * @param \Google_Service_Directory $service
     * @param $email
     * @param $params
     * @return Google_Service_Directory_User
     */
    public function getInfosFromEmail($service, $email, $params)
    {
        if (is_null($service)) {
            $service = $this->innitApi($params);
        }
        return $service->users->get($email);
    }

    /**
     * @param $service
     * @param $params
     * @return integer
     */
    public function numberGmailUsers($service, $params)
    {
        if (is_null($service)) {
            $service = $this->innitApi($params);
        }
        $nbGoogleUsed = 0;
        $this->pageToken = null;
        do {
            $result = $service->users->listUsers(array('domain' => 'aramisauto.com', 'viewType' => 'ADMIN_VIEW', 'maxResults' => 500, 'pageToken' => $this->pageToken));
            $this->pageToken = $result->getNextPageToken();
            $nbGoogleUsed = $nbGoogleUsed + count($result->getUsers());
        } while (count($result->getUsers()) == 500);

        return $nbGoogleUsed;
    }

    /**
     * @param $params
     * @param $user
     * @param string $newAlias
     * @return \Google_Service_Directory_Alias
     */
    public function addAliasToUser($params, $user, $newAlias)
    {
        $service = $this->innitApi($params);
        $alias = new \Google_Service_Directory_Alias();
        $alias->setAlias($newAlias);
        try {
            $service->users_aliases->insert($user, $alias);
            $this->utilisateurManager->appendSessionMessaging(array('errorCode' => '0', 'message' => 'L\alias '.$newAlias.' a été ajouté correctement'));
        } catch (Exception $e) {
            $this->utilisateurManager->appendSessionMessaging(array('errorCode' => error_log($e->getMessage()), 'message' => $e->getMessage()));
        }
    }

    /**
     * @param $params
     * @param $user
     * @param string $newAlias
     * @return \Google_Service_Directory_Alias
     */
    public function deleteAliasToUser($params, $user, $newAlias)
    {
        $service = $this->innitApi($params);
        $alias = new \Google_Service_Directory_Alias();
        $alias->setAlias($newAlias);
        try {
            $service->users_aliases->delete($user, $alias);
            $this->utilisateurManager->appendSessionMessaging(array('errorCode' => '0', 'message' => 'L\alias '.$newAlias.' a été ajouté correctement'));
        } catch (Exception $e) {
            $this->utilisateurManager->appendSessionMessaging(array('errorCode' => error_log($e->getMessage()), 'message' => $e->getMessage()));
        }
    }

    /**
     * @param $tabToSend
     * @param $googleApiParams
     */
    private function progagateInGmailIfServiceOrFonctionModified($tabToSend, $googleApiParams)
    {
        if ($tabToSend['utilisateurOldService'] != $tabToSend['utilisateurService'] || $tabToSend['utilisateurOldFonction'] != $tabToSend['utilisateurFonction']) {
            $this->googleGroupApiService->addOrDeleteUserFromGroups($googleApiParams, $tabToSend['newDatas']['mail'], $this->googleGroupManager->transformMatchArrayToListOfEmail($this->googleGroupMatchFonctionAndServiceManager->globalGroupListToAdd($tabToSend['utilisateurOldService'], $tabToSend['utilisateurOldFonction'])), 'supprimé');
            $this->googleGroupApiService->addOrDeleteUserFromGroups($googleApiParams, $tabToSend['newDatas']['mail'], $this->googleGroupManager->transformMatchArrayToListOfEmail($this->googleGroupMatchFonctionAndServiceManager->globalGroupListToAdd($tabToSend['utilisateurService'], $tabToSend['utilisateurFonction'])), 'ajouté');
        }
    }

    /**
     * @param $tabToSend
     * @param $googleApiParams
     */
    public function modifyInfosForUser($tabToSend, $googleApiParams)
    {
        $service = $this->innitApi($googleApiParams);
        $user = $this->initBaseUser($tabToSend['newDatas']['givenName'], $tabToSend['newDatas']['sn'], $tabToSend['newDatas']['mail']);
        try {
            $this->updateAccountWithInfos($service, $tabToSend['utilisateurOldEmail'], $user);
            $this->utilisateurManager->appendSessionMessaging(array('errorCode' => '0', 'message' => 'Le mail '.$tabToSend['newDatas']['mail'].' a été mis à jour correctement'));
            $this->progagateInGmailIfServiceOrFonctionModified($tabToSend, $googleApiParams);
        } catch (Exception $e) {
            $this->utilisateurManager->appendSessionMessaging(array('errorCode' => error_log($e->getMessage()), 'message' => $e->getMessage()));
        }
    }

    /**
     * @param \Google_Service_Directory $service
     * @param $userToCreate
     * @return mixed
     */
    public function createNewUserAccount($service, $userToCreate)
    {
        return $service->users->insert($this->initUserAccount($userToCreate));
    }

    /**
     * @param \Google_Service_Directory $service
     * @param $email
     * @param Google_Service_Directory_User $userToUpdate
     * @return mixed
     */
    public function updateAccountWithInfos($service, $email, $userToUpdate)
    {
        return $service->users->update($email, $userToUpdate);
    }

    /**
     * @param $service
     * @param $userToCreate
     * @return mixed
     */
    public function deleteAccount($service, $userToCreate)
    {
        return $service->users->delete($userToCreate['email']);
    }

    /**
     * @param $params
     * @param string $email
     * @return \Google_Service_Directory_UserPhoto
     */
    public function getPhotoOfUser($params, $email)
    {
        return $this->innitApi($params)->users_photos->get($email);
    }

    /**
     * @param $sendaction
     * @param $isCreateInGmail
     * @param $request
     */
    public function ifGmailCreate($sendaction, $isCreateInGmail, $request, $params)
    {
        if ($sendaction == "Créer sur Gmail" && ($isCreateInGmail == null || $isCreateInGmail == 0)) {
            $this->ifEmailNotExistCreateUser(array('nom' => $request->request->get('utilisateur')['name'], 'prenom' => $request->request->get('utilisateur')['surname'], 'email' => $request->request->get('genEmail'), 'password' => $request->request->get('utilisateur')['mainPassword']), $params);
            $this->utilisateurManager->setEmail($request->request->get('utilisateur')['id'], $request->request->get('genEmail'));
            $this->googleGroupApiService->addOrDeleteUserFromGroups($params, $request->request->get('genEmail'), $this->googleGroupManager->transformMatchArrayToListOfEmail($this->googleGroupMatchFonctionAndServiceManager->globalGroupListToAdd($request->request->get('utilisateur')['service'], $request->request->get('utilisateur')['fonction'])), 'ajouté');
        }
    }

    /**
     * @param GoogleGroupApiService $googleGroupApiService
     * @return GoogleUserApiService
     */
    public function setGoogleGroupApiService($googleGroupApiService)
    {
        $this->googleGroupApiService = $googleGroupApiService;
        return $this;
    }
}
