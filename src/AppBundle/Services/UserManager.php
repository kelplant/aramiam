<?php
namespace AppBundle\Services;

use AppBundle\Entity\User;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Class ParametersManager
 * @package CoreBundle\Services\Manager
 */
class UserManager
{
    private $managerRegistry;

    private $em;
    /**
     * MouvHistoryManager constructor.
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(ManagerRegistry $managerRegistry) {
        $this->managerRegistry = $managerRegistry;
        $item = new User();
        $this->em = $this->managerRegistry->getManagerForClass(get_class($item));
    }

    /**
     * @param $name
     * @return mixed
     */
    public function getId($name)
    {
        return $this->em->getRepository('AppBundle:User')->findOneByUsername($name)->getId();
    }

    /**
     * @param $name
     * @return mixed
     */
    public function getEmail($name)
    {
        return $this->em->getRepository('AppBundle:User')->findOneByUsername($name)->getEmail();
    }
}