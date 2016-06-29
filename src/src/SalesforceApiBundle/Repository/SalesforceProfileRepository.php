<?php
namespace SalesforceApiBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class SalesforceProfileRepository
 * @package SalesforceApiBundle\Repository
 */
class SalesforceProfileRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function findAll()
    {
        return $this->findBy(array(), array('profileName' => 'ASC'));
    }
}