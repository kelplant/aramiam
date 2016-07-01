<?php
namespace SalesforceApiBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class SalesforceGroupeMatchFonctionRepository
 * @package SalesforceApiBundle\Repository
 */
class SalesforceGroupeMatchFonctionRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function findAll()
    {
        return $this->findBy(array(), array('id' => 'ASC'));
    }
}