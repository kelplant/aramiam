<?php
namespace SalesforceApiBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class ApplicationRepository
 * @package SalesforceApiBundle\Repository
 */
class SalesforceRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function findAll()
    {
        return $this->findBy(array(), array('name' => 'ASC'));
    }
}