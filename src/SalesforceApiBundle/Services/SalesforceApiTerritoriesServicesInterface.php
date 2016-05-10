<?php
namespace  SalesforceApiBundle\Services;

interface SalesforceApiTerritoriesServicesInterface
{
    public function connnect($params);
    public function executeQuery($query, $params, $json, $action);
    public function getListOfProfiles($params);
    public function setTokenManager($tokenManager);
    public function setSecurityContext($securityContext);
    public function setParametersManager($parametersManager);
    public function addUserToTerritory($params, $userInTerritoryToAdd);
    public function getListOfTerritories($params);
    public function addTerritoriesForNewUser($userId, $fonctionId, $params);
}