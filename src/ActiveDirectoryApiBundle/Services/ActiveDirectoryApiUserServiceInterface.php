<?php
namespace  ActiveDirectoryApiBundle\Services;

interface ActiveDirectoryApiServiceInterface
{
    public function connectAD($connectionADparams);
    public function pwd_encryption($newPassword);
    public function toReadableGuid($guidFromAd);
    public function createUser($connectionADparams, $userToCreateDn, $userToCreate);
    public function executeQueryWithFilter($connectionADparams, $filter, $elemsToReturn);
    public function modifyInfosForUser($userId, $paramsAD, $updatedItem, $userServiceId, $userFonctionId, $oldService, $oldFonction);
    public function ifWindowsCreate($sendaction, $isCreateInWindows, $request, $paramsAD);
    public function ifWindowsUpdate($sendaction, $request, $paramsAD);
    public function setActiveDirectoryApiGroupService($activeDirectoryApiGroupService);
}