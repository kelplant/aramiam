<?php
namespace  ActiveDirectoryApiBundle\Services;

interface ActiveDirectoryApiServiceInterface
{
    public function toReadableGuid($guidFromAd);
    public function createUser($connectionADparams, $userToCreateDn, $userToCreate);
    public function executeQueryWithFilter($connectionADparams, $filter, $elemsToReturn);
    public function addToADGroup($ds, $groupDn, $userDn);
    public function ifWindowsCreate($sendaction, $isCreateInWindows, $request, $paramsAD);
}