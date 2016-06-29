<?php
namespace OdigoApiBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class OrangeTelListeRepository
 * @package OdigoApiBundle\Repository
 */
class OrangeTelListeRepository extends EntityRepository
{
    public function findAll()
    {
        return $this->findBy(array(), array('numero' => 'ASC'));
    }
}