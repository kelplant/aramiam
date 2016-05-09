<?php
namespace  ActiveDirectoryApiBundle\Services;

interface ActiveDirectoryApiServiceInterface
{
    public function connectAD($connectionADparams);
    public function pwd_encryption($newPassword);
    public function toReadableGuid($guidFromAd);
    public function createUser($connectionADparams, $userToCreateDn, $userToCreate);
    public function executeQueryWithFilter($connectionADparams, $filter, $elemsToReturn);
    public function addToADGroup($ds, $groupDn, $userDn);
    public function removeUserFromGroup($ds, $group, $group_info);
    public function parseServiceAndFonctionAndDoAction($paramsAD, $serviceId, $fonctionId, $userDn, $action);
    public function modifyInfosForUser($userId, $paramsAD, $updatedItem, $userServiceId, $userFonctionId, $oldService, $oldFonction);
    public function ifWindowsCreate($sendaction, $isCreateInWindows, $request, $paramsAD);
}