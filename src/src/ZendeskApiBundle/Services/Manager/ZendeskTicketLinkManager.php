<?php
namespace ZendeskApiBundle\Services\Manager;

use ZendeskApiBundle\Entity\ZendeskTicketLink;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Class ZendeskTicketLinkManager
 * @package ZendeskApiBundle\Services\Manager
 */
class ZendeskTicketLinkManager
{
    /**
     * @var ManagerRegistry
     */
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
        return $this->em->getRepository('ZendeskApiBundle:ZendeskTicketLink')->findOneByCandidatId($candidatId);
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

    /**
     * @param $ticketId
     */
    public function removeByTicketId($ticketId) {

        $this->em->remove($this->em->getRepository('ZendeskApiBundle:ZendeskTicketLink')->findOneByTicketId($ticketId));
        $this->em->flush();

        return;
    }
}