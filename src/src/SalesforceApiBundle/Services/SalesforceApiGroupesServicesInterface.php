<?php
namespace  SalesforceApiBundle\Services;

interface SalesforceApiGroupesServicesInterface
{
    public function connnect($params);
    public function executeQuery($query, $params, $json, $action);
    public function getListOfProfiles($params);
    public function getLiencesInformations($params);
    public function setTokenManager($tokenManager);
    public function setSecurityContext($securityContext);
    public function setParametersManager($parametersManager);
    public function addUserToGroupe($params, $userInGroupeToAdd);
    public function deleteUserFromGroupe($params, $groupMemberId);
    public function getTheGroupId($params, $userId, $groupId);
    public function getListOfGroupes($params);
    public function getListOfGroupesForUser($params, $userId);
    public function listOfGroupesForFonction($fonctionId);
    public function addGroupesForNewUser($userId, $fonctionId, $params);
    public function deleteGroupesForUser($salesforceUserId, $fonctionId, $params);
}