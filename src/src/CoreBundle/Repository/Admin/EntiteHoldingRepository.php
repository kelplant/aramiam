<?php
namespace CoreBundle\Repository\Admin;

use Doctrine\ORM\EntityRepository;

/**
 * Class EntiteHoldingRepository
 * @package CoreBundle\Repository\Admin
 */
class EntiteHoldingRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function findAll()
    {
        return $this->findBy(array(), array('name' => 'ASC'));
    }
}