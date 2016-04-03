<?php
namespace AppBundle\Services;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;

/**
 * Class ParametersManager
 * @package CoreBundle\Services\Manager
 */
class UserManager
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