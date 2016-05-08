<?php
namespace AppBundle\Services;

use AppBundle\Entity\User;
use AppBundle\Services\Manager\AbstractManager;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Class UserManager
 * @package AppBundle\Services
 */
class UserManager extends AbstractManager
{
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