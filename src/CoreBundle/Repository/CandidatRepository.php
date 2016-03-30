<?php
/**
 * Created by PhpStorm.
 * User: Xavier
 * Date: 26/03/2016
 * Time: 12:43
 */
namespace CoreBundle\Repository;

use CoreBundle\Entity\Candidat;
use Doctrine\ORM\EntityRepository;

class CandidatRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function findAll()
    {
        return $this->findBy(array(), array('startDate' => 'DESC'));
    }
}