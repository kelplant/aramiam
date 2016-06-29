<?php
namespace SalesforceApiBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class SalesforceTokenStoreRepository
 * @package SalesforceApiBundle\Repository
 */
class SalesforceTokenStoreRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function findAll()
    {
        return $this->findBy(array(), array('username' => 'ASC'));
    }
}