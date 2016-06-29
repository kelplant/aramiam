<?php
namespace SalesforceApiBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class SalesforceTerritoryRepository
 * @package SalesforceApiBundle\Repository
 */
class SalesforceTerritoryRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function findAll()
    {
        return $this->findBy(array(), array('territoryName' => 'ASC'));
    }
}