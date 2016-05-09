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
     * @var GoogleGroupApiService;
     */
    public $googleGroupApiService;

    /**
     * @param $userToCreate
     * @param $service
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
     * @param $userToCreate
     * @return Google_Service_Directory_User
     */
    private function initUserAccount($userToCreate)
    {
        $user = new Google_Service_Directory_User();
        $name = new Google_Service_Directory_UserName();
        $name->setGivenName($userToCreate['prenom']);
        $name->setFamilyName($userToCreate['nom']);
        $user->setName($name);
        $user->setHashFunction("SHA-1");
        $user->setPrimaryEmail($userToCreate['email']);
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
     * @param $service
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
     * @param $params
     * @param $user
     * @param $newAlias
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


    public function modifyInfosForUser($email, $newDatas, $serviceId, $fonctionId, $oldServiceId, $oldFonctionId)
    {

    }

    /**
     * @param $service
     * @param $userToCreate
     * @return mixed
     */
    public function createNewUserAccount($service, $userToCreate)
    {
        return $service->users->insert($this->initUserAccount($userToCreate));
    }

    /**
     * @param $service
     * @param $userToCreate
     * @return mixed
     */
    public function updateAccountWithInfos($service, $userToCreate)
    {
        return $service->users->update($userToCreate['email'], $userToCreate);
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
     * @param $email
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
            $this->googleGroupApiService->addOrDeleteUserFromGroups(
                $params,
                $request->request->get('genEmail'),
                $this->googleGroupManager->transformMatchArrayToListOfEmail(
                    $this->googleGroupMatchFonctionAndServiceManager->globalGroupListToAdd(
                        $request->request->get('utilisateur')['service'],
                        $request->request->get('utilisateur')['fonction']
                    )
                ),
                'ajouté'
            );
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
