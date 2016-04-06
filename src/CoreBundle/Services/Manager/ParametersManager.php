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
        try {
            return $this->em->getRepository('CoreBundle:Parameters')->findOneByParamName($name)->getParamValue();
        }catch (\Exception $e) {
            return error_log($e->getMessage());
        }
    }

    /**
     * @param $app
     * @return array
     */
    public function getAllAppParams($app)
    {
        try {
            return $this->em->getRepository('CoreBundle:Parameters')->findByApplication($app);
        }catch (\Exception $e) {
            return error_log($e->getMessage());
        }
    }

    /**
     * @param $name
     * @param $value
     * @param $application
     * @return bool|void
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
        }catch (\Exception $e) {
            return error_log($e->getMessage());
        }
    }
}