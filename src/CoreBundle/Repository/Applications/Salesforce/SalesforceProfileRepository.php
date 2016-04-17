<?php
namespace CoreBundle\Repository\Applications\Salesforce;

use Doctrine\ORM\EntityRepository;

/**
 * Class SalesforceProfileRepository
 * @package CoreBundle\Repository\Applications\Salesforce
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