<?php
namespace OdigoApiBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class OdigoTelListeRepository
 * @package OdigoApiBundle\Repository
 */
class OdigoTelListeRepository extends EntityRepository
{
    public function findAll()
    {
        return $this->findBy(array(), array('numero' => 'ASC'));
    }
}