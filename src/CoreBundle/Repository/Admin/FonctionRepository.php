<?php
namespace CoreBundle\Repository\Admin;

use Doctrine\ORM\EntityRepository;

class FonctionRepository extends EntityRepository
{
    public function findAll()
    {
        return $this->findBy(array(), array('name' => 'ASC'));
    }
}