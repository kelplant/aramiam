<?php
namespace CoreBundle\Services\Manager;

use CoreBundle\Entity\Parameters;
use Doctrine\ORM\EntityManager;

class ParametersManager
{
    public function __construct(EntityManager $entityManager) {
        $this->em = $entityManager;
    }
    public function getParam($name)
    {
        $param = $this->em->getRepository('CoreBundle:Parameters')->findOneByParamName($name);

        return $value = $param->getParamValue();
    }

    /**
     * @param $app
     * @return array
     */
    public function getAllAppParams($app)
    {
        $param = $this->em->getRepository('CoreBundle:Parameters')->findByApplication($app);

        return $param;
    }

    /**
     * @param $name
     * @param $value
     */
    public function setParamForName($name, $value, $application)
    {
        $repository = $this->em->getRepository('CoreBundle:Parameters');
        $insert = $repository->findOneByParamName($name);
        if ($insert == NULL)
        {
            $insert = new Parameters();
        }
        $insert->setParamName($name);
        $insert->setParamValue($value);
        $insert->setApplication($application);

        $this->em->persist($insert);
        $this->em->flush();

        return;
    }
}