<?php
namespace CoreBundle\Repository\Applications\Odigo;

use Doctrine\ORM\EntityRepository;

class OdigoTelListeRepository extends EntityRepository
{
    public function findAll()
    {
        return $this->findBy(array(), array('numero' => 'ASC'));
    }
}