<?php
namespace CoreBundle\Services\Manager;

use CoreBundle\Entity\Parameters;
use Doctrine\ORM\EntityManager;

/**
 * Class ParametersManager
 * @package CoreBundle\Services\Manager
 */
class ParametersManager
{
    private $em;

    /**
     * ParametersManager constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager) {
        $this->em = $entityManager;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function getParam($name)
    {
        return $this->em->getRepository('CoreBundle:Parameters')->findOneByParamName($name)->getParamValue();
    }

    /**
     * @param $app
     * @return array
     */
    public function getAllAppParams($app)
    {
        return $this->em->getRepository('CoreBundle:Parameters')->findByApplication($app);
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