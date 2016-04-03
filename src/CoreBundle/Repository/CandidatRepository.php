<?php
namespace CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CandidatRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function findAll()
    {
        return $this->findBy(array(), array('startDate' => 'ASC'));
    }
}