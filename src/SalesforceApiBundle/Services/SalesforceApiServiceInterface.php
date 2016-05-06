<?php
namespace  SalesforceApiBundle\Services;

interface SalesforceApiServiceInterface
{
    public function executeQuery($query, $params, $json, $action);
    public function createNewUser($params, $newSalesforceUser);
    public function addUserToGroupe($params, $userInGroupeToAdd);
    public function addUserToTerritory($params, $userInTerritoryToAdd);
    public function getListOfProfiles($params);
    public function getListOfTerritories($params);
    public function getListOfGroupes($params);
    public function getAccountByUsername($emailToLook, $params);
}