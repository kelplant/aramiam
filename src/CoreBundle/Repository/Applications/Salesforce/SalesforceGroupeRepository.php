<?php
namespace CoreBundle\Repository\Applications\Salesforce;

use Doctrine\ORM\EntityRepository;

/**
 * Class SalesforceGroupeRepository
 * @package CoreBundle\Repository\Applications\Salesforce
 */
class SalesforceGroupeRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function findAll()
    {
        return $this->findBy(array(), array('groupeName' => 'ASC'));
    }
}