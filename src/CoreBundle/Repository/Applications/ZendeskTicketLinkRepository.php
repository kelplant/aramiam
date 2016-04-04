<?php
namespace CoreBundle\Repository\Applications;

use Doctrine\ORM\EntityRepository;

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