<?php
namespace AramisApiBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class AramisAgencyRepository
 * @package AramisApiBundle\Repository
 */
class AramisAgencyRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function findAll()
    {
        return $this->findBy(array(), array('label' => 'ASC'));
    }
}