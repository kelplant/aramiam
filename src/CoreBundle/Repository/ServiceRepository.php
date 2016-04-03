<?php
namespace CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ServiceRepository extends EntityRepository
{
    public function findAll()
    {
        return $this->findBy(array(), array('name' => 'ASC'));
    }
}