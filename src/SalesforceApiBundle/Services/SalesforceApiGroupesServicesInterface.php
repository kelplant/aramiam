<?php
namespace  SalesforceApiBundle\Services;

interface SalesforceApiGroupesServicesInterface
{
    public function connnect($params);
    public function executeQuery($query, $params, $json, $action);
    public function getListOfProfiles($params);
    public function setTokenManager($tokenManager);
    public function setSecurityContext($securityContext);
    public function setParametersManager($parametersManager);
    public function addUserToGroupe($params, $userInGroupeToAdd);
    public function getListOfGroupes($params);
    public function addGroupesForNewUser($userId, $fonctionId, $params);
}