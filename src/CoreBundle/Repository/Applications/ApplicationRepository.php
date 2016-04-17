<?php
namespace CoreBundle\Repository\Applications;

use Doctrine\ORM\EntityRepository;

/**
 * Class ApplicationRepository
 * @package CoreBundle\Repository\Applications
 */
class ApplicationRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function findAll()
    {
        return $this->findBy(array(), array('name' => 'ASC'));
    }
}