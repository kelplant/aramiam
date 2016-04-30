<?php
namespace  OdigoApiBundle\Services;

interface OdigoClientServiceInterface
{
    public function create($parameters, $userBeanInfos);
    public function createwithtemplate($parameters, $userBeanWithTemplateInfos);
    public function delete($parameters, $userId);
    public function export($parameters, $AutoUserAdmin);
}