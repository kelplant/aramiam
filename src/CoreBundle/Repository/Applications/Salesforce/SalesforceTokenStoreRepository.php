<?php
namespace CoreBundle\Repository\Applications\Salesforce;

use Doctrine\ORM\EntityRepository;

class SalesforceTokenStoreRepository extends EntityRepository
{
    public function findAll()
    {
        return $this->findBy(array(), array('username' => 'ASC'));
    }
}