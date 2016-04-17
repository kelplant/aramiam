<?php
namespace CoreBundle\Repository\Applications;

use Doctrine\ORM\EntityRepository;

/**
 * Class ZendeskTicketLinkRepository
 * @package CoreBundle\Repository\Applications
 */
class ZendeskTicketLinkRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function findAll()
    {
        return $this->findBy(array(), array('id' => 'ASC'));
    }
}