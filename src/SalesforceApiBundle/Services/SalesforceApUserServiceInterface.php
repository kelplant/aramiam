<?php
namespace  SalesforceApiBundle\Services;

interface SalesforceApiUserServiceInterface
{
    public function connnect($params);
    public function executeQuery($query, $params, $json, $action);
    public function getListOfProfiles($params);
    public function setTokenManager($tokenManager);
    public function setSecurityContext($securityContext);
    public function setParametersManager($parametersManager);
    public function createNewUser($params, $newSalesforceUser);
    public function updateUser($params, $newSalesforceUser);
    public function getAccountByUsername($emailToLook, $params);
    public function getAllInfosForAccountByUsername($emailToLook, $params);
    public function ifSalesforceCreate($sendaction, $isCreateInSalesforce, $request, $params);
}