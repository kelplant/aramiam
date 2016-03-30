<?php
// ZendeskBundle/Services/ParametersManager.php

namespace ZendeskBundle\Services\Manager;

use ZendeskBundle\Entity\Parameters;
use Doctrine\ORM\EntityManager;

class ParametersManager
{
    public function __construct(EntityManager $entityManager) {
        $this->em = $entityManager;
    }
    public function getParam($name)
    {
        $param = $this->em->getRepository('ZendeskBundle:Parameters')->findOneByParamName($name);

        return $value = $param->getParamValue();
    }
    public function setParam($name, $value)
    {
        $repository = $this->em->getRepository('ZendeskBundle:Parameters');
        $testInsert = $repository->findOneByParamName($name);

        if ($testInsert == "")
        {
            $param = new Parameters();
            $param->setParamName($name);
            $param->setParamValue($value);

            $this->em->persist($param);
            $this->em->flush();

            return;
        }
    }
}