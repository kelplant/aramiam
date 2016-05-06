<?php
namespace  SalesforceApiBundle\Services;

interface SalesforceApiGroupesServicesInterface
{
    public function addGroupesForNewUser($userId, $fonctionId, $params);
}