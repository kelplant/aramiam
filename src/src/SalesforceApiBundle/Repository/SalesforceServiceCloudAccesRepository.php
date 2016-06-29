<?php
namespace SalesforceApiBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class SalesforceServiceCloudAccesRepository
 * @package SalesforceApiBundle\Repository
 */
class SalesforceServiceCloudAccesRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function findAll()
    {
        return $this->findBy(array(), array('id' => 'ASC'));
    }
}