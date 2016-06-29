<?php
namespace SalesforceApiBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class SalesforceGroupeRepository
 * @package SalesforceApiBundle\Repository
 */
class SalesforceGroupeRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function findAll()
    {
        return $this->findBy(array(), array('groupeName' => 'ASC'));
    }
}