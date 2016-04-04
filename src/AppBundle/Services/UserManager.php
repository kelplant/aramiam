<?php
namespace AppBundle\Services;

use AppBundle\Entity\User;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Class UserManager
 * @package AppBundle\Services
 */
class UserManager
{
    private $managerRegistry;

    private $em;

    /**
     * UserManager constructor.
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(ManagerRegistry $managerRegistry) {
        $this->managerRegistry = $managerRegistry;
        $this->em = $this->managerRegistry->getManagerForClass(User::class);
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