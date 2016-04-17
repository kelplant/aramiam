<?php
namespace CoreBundle\Repository\Applications\Salesforce;

use Doctrine\ORM\EntityRepository;

/**
 * Class SalesforceTokenStoreRepository
 * @package CoreBundle\Repository\Applications\Salesforce
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