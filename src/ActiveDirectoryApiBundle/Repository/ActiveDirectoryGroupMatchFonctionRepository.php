<?php
namespace ActiveDirectoryApiBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class ActiveDirectoryGroupMatchFonctionRepository
 * @package ActiveDirectoryApiBundle\Repository
 */
class ActiveDirectoryGroupMatchFonctionRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function findAll()
    {
        return $this->findBy(array(), array('id' => 'ASC'));
    }
}