<?php
namespace  GoogleApiBundle\Services;

interface GoogleUserApiServiceInterface
{
    public function innitApi($params);
    public function base64safeToBase64($data);
    public function getInfosFromEmail($service, $email, $params);
    public function addAliasToUser($params, $user, $newAlias);
    public function createNewUserAccount($service, $userToCreate);
    public function updateAccountWithInfos($service, $userToCreate);
    public function deleteAccount($service, $userToCreate);
    public function getPhotoOfUser($params, $email);
    public function ifGmailCreate($sendaction, $isCreateInGmail, $request, $params);
}