<?php
namespace ActiveDirectoryApiBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class ActiveDirectoryGroupMatchServicepRepository
 * @package ActiveDirectoryApiBundle\Repository
 */
class ActiveDirectoryGroupMatchServiceRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function findAll()
    {
        return $this->findBy(array(), array('id' => 'ASC'));
    }
}