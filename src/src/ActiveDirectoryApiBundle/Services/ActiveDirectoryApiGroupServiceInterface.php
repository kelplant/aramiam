<?php
namespace  ActiveDirectoryApiBundle\Services;

interface ActiveDirectoryApiGroupServiceInterface
{
    public function connectAD($connectionADparams);
    public function pwd_encryption($newPassword);
    public function toReadableGuid($guidFromAd);
    public function addToADGroup($ds, $groupDn, $userDn);
    public function removeUserFromGroup($ds, $group, $group_info);
    public function parseServiceAndFonctionAndDoAction($paramsAD, $serviceId, $fonctionId, $userDn, $action);
    public function progagateInActiveDirectoryIfServiceOrFonctionModified($tabToSend, $activeDirectoryParams, $newcn);
}