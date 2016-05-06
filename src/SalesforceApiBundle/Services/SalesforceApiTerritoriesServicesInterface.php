<?php
namespace  SalesforceApiBundle\Services;

interface SalesforceApiTerritoriesServicesInterface
{
    public function addTerritoriesForNewUser($userId, $fonctionId, $params);
}