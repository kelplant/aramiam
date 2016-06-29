<?php
namespace CoreBundle\Repository\Admin;

use Doctrine\ORM\EntityRepository;

/**
 * Class CandidatRepository
 * @package CoreBundle\Repository\Admin
 */
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