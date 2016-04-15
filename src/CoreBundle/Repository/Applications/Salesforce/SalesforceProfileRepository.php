<?php
namespace CoreBundle\Repository\Applications\Salesforce;

use Doctrine\ORM\EntityRepository;

class SalesforceProfileRepository extends EntityRepository
{
    public function findAll()
    {
        return $this->findBy(array(), array('profileName' => 'ASC'));
    }
}