<?php
namespace CoreBundle\Services\Manager;

use CoreBundle\Entity\Parameters;
use Doctrine\Common\Persistence\ManagerRegistry;

class ParametersManager
{
    private $managerRegistry;

    private $em;

    /**
     * ParametersManager constructor.
     * @param ManagerRegistry $managerRegistry
     * @param Parameters $parameters
     */
    public function __construct(ManagerRegistry $managerRegistry, Parameters $parameters) {
        $this->managerRegistry = $managerRegistry;
        $this->em = $this->managerRegistry->getManagerForClass(get_class($parameters));
    }

    /**
     * @param $name
     * @return string
     */
    public function getParam($name)
    {
        $param = $this->em->getRepository('ZendeskBundle:Parameters')->findOneByParamName($name);

        return $param->getParamValue();
    }

    /**
     * @param $app
     * @return array
     */
    public function getAllAppParams($app)
    {
        $param = $this->em->getRepository('ZendeskBundle:Parameters')->findByApplication($app);

        return $param;
    }

    /**
     * @param $name
     * @param $value
     */
    public function setParamForName($name, $value, $application)
    {
        $repository = $this->em->getRepository('ZendeskBundle:Parameters');
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