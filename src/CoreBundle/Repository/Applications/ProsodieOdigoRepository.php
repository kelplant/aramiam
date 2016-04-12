<?php
namespace CoreBundle\Repository\Applications;

use Doctrine\ORM\EntityRepository;

class ProsodieOdigoRepository extends EntityRepository
{
    public function findAll()
    {
        return $this->findBy(array(), array('id' => 'ASC'));
    }
}