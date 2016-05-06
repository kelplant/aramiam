<?php
namespace  SalesforceApiBundle\Services;

interface SalesforceApiUserServiceInterface
{
    public function ifSalesforceCreate($sendaction, $isCreateInSalesforce, $request, $params);
}