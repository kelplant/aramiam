<?php
namespace CoreBundle\Services\Manager;

use CoreBundle\Entity\Parameters;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Class ParametersManager
 * @package CoreBundle\Services\Manager
 */
class ParametersManager
{
    private $managerRegistry;

    private $em;
    /**
     * MouvHistoryManager constructor.
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(ManagerRegistry $managerRegistry) {
        $this->managerRegistry = $managerRegistry;
        $this->em = $this->managerRegistry->getManagerForClass(Parameters::class);
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
        $return = [];
        foreach ($this->em->getRepository('CoreBundle:Parameters')->findByApplication($app) as $param) {
                $return[$param->getParamName()] = $param->getParamValue();
        }
        return $return;
    }

    /**
     * @param $name
     * @param $value
     * @param $application
     * @return string
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

        try {
            $this->em->persist($insert);
            $this->em->flush();
            return null;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}