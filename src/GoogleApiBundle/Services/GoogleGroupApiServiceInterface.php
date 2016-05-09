<?php
namespace  GoogleApiBundle\Services;

interface GoogleApiServiceInterface
{
    public function innitApi($params);
    public function base64safeToBase64($data);
    public function getListeOfGroupes($params);
    public function addUserToGroups($params, $user, $listOfGroupsEmails);
}