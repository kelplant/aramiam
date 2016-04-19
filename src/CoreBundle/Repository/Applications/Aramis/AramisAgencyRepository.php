<?php
namespace CoreBundle\Repository\Applications\Aramis;

use Doctrine\ORM\EntityRepository;

/**
 * Class ApplicationRepository
 * @package CoreBundle\Repository\Applications
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