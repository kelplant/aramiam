<?php
namespace ActiveDirectoryApiBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class ActiveDirectoryGroupRepository
 * @package ActiveDirectoryApiBundle\Repository
 */
class ActiveDirectoryGroupRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function findAll()
    {
        return $this->findBy(array(), array('name' => 'ASC'));
    }
}