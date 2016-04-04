<?php
namespace CoreBundle\Services\Manager\Applications;

use CoreBundle\Entity\Applications\ZendeskTicketLink;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Class ZendeskTicketLinkManager
 * @package CoreBundle\Services\Manager
 */
class ZendeskTicketLinkManager
{
    private $managerRegistry;

    private $em;
    /**
     * MouvHistoryManager constructor.
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(ManagerRegistry $managerRegistry) {
        $this->managerRegistry = $managerRegistry;
        $this->em = $this->managerRegistry->getManagerForClass(ZendeskTicketLink::class);
    }

    /**
     * @param $candidatId
     * @return mixed
     */
    public function getNumTicket($candidatId)
    {
        return $this->em->getRepository('CoreBundle:Applications\ZendeskTicketLink')->findOneByCandidatId($candidatId);
    }

    /**
     * @param $candidatId
     * @param $ticketId
     */
    public function setParamForName($candidatId, $ticketId)
    {
        $insert = new ZendeskTicketLink();

        $insert->setCandidatId($candidatId);
        $insert->setTicketId($ticketId);

        $this->em->persist($insert);
        $this->em->flush();

        return;
    }
}