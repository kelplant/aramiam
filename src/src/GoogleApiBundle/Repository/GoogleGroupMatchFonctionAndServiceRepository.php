<?php
namespace GoogleApiBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class GoogleGroupMatchFonctionAndServiceRepository
 * @package GoogleApiBundle\Repository
 */
class GoogleGroupMatchFonctionAndServiceRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function findAll()
    {
        return $this->findBy(array(), array());
    }
}