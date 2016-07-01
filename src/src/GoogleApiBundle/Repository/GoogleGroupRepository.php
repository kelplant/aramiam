<?php
namespace GoogleApiBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class GoogleGroupRepository
 * @package GoogleApiBundle\Repository
 */
class GoogleGroupRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function findAll()
    {
        return $this->findBy(array(), array('email' => 'ASC'));
    }
}