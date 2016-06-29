<?php
namespace  OdigoApiBundle\Services;

interface OdigoApiServiceInterface
{
    public function ifOdigoCreate($sendaction, $isCreateInOdigo, $request, $paramsOdigo, $paramsGoogle);
    public function deleteOdigoUser($odigoUserId, $paramsOdigo);
    public function exportOdigoModifications($paramsOdigo);
}