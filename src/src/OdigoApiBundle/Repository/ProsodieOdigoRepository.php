<?php
namespace OdigoApiBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class ProsodieOdigoRepository
 * @package OdigoApiBundle\Repository
 */
class ProsodieOdigoRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function findAll()
    {
        return $this->findBy(array(), array('id' => 'ASC'));
    }
}