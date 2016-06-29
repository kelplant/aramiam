<?php
namespace SalesforceApiBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class SalesforceTerritoryMatchServiceRepository
 * @package SalesforceApiBundle\Repository
 */
class SalesforceTerritoryMatchServiceRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function findAll()
    {
        return $this->findBy(array(), array('id' => 'ASC'));
    }
}