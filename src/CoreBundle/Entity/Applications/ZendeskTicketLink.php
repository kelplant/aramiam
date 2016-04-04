<?php
namespace CoreBundle\Entity\Applications;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class ZendeskTicketLink
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\Applications\ZendeskTicketLinkRepository")
 * @ORM\Table(name="core_app_zendeskticketlink")
 */
class ZendeskTicketLink
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="integer")
     */
    protected $candidatId;

    /**
     * @var string
     * @ORM\Column(type="string", length=100)
     */
    protected $ticketId;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return ZendeskTicketLink
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getCandidatId()
    {
        return $this->candidatId;
    }

    /**
     * @param string $candidatId
     * @return ZendeskTicketLink
     */
    public function setCandidatId($candidatId)
    {
        $this->candidatId = $candidatId;
        return $this;
    }

    /**
     * @return string
     */
    public function getTicketId()
    {
        return $this->ticketId;
    }

    /**
     * @param string $ticketId
     * @return ZendeskTicketLink
     */
    public function setTicketId($ticketId)
    {
        $this->ticketId = $ticketId;
        return $this;
    }
}