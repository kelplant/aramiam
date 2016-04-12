<?php
namespace CoreBundle\Repository\Applications;

use Doctrine\ORM\EntityRepository;

class ApplicationRepository extends EntityRepository
{
    public function findAll()
    {
        return $this->findBy(array(), array('name' => 'ASC'));
    }
}