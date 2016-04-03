<?php
namespace CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UtilisateurRepository extends EntityRepository
{
    public function findAll()
    {
        return $this->findBy(array(), array('startDate' => 'DESC'));
    }
}