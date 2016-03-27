<?php
/**
     * Created by PhpStorm.
     * User: Xavier
     * Date: 26/03/2016
     * Time: 12:43
     */
namespace CoreBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class CandidatRepository extends EntityRepository
{
    public function findAll()
    {
        return $this->findBy(array(), array('startDate' => 'DESC'));
    }
}