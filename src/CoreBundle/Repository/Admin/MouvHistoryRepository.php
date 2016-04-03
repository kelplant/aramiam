<?php
namespace CoreBundle\Repository\Admin;

use Doctrine\ORM\EntityRepository;

class MouvHistoryRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function findAll()
    {
        return $this->findBy(array(), array('startDate' => 'ASC'));
    }
}