<?php
namespace ZendeskApiBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class ZendeskTicketLinkRepository
 * @package ZendeskApiBundle\Repository
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