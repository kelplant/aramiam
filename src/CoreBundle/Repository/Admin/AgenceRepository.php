<?php
namespace CoreBundle\Repository\Admin;

use Doctrine\ORM\EntityRepository;

class AgenceRepository extends EntityRepository
{
    public function findAll()
    {
        return $this->findBy(array(), array('name' => 'ASC'));
    }
}