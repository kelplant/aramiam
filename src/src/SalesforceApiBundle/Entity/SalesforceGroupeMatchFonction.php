<?php
namespace SalesforceApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * @ORM\Table(name="salesforce_groupe_match_fonction")
 * @ORM\Entity(repositoryClass="SalesforceApiBundle\Repository\SalesforceGroupeMatchFonctionRepository")
 */
class SalesforceGroupeMatchFonction
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
     * @ORM\Column(type="string")
     */
    protected $fonctionId;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $salesforceGroupe;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $createdAt;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $updatedAt;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return SalesforceGroupeMatchFonction
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getFonctionId()
    {
        return $this->fonctionId;
    }

    /**
     * @param string $fonctionId
     * @return SalesforceGroupeMatchFonction
     */
    public function setFonctionId($fonctionId)
    {
        $this->fonctionId = $fonctionId;
        return $this;
    }

    /**
     * @return string
     */
    public function getSalesforceGroupe()
    {
        return $this->salesforceGroupe;
    }

    /**
     * @param string $salesforceGroupe
     * @return SalesforceGroupeMatchFonction
     */
    public function setSalesforceGroupe($salesforceGroupe)
    {
        $this->salesforceGroupe = $salesforceGroupe;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     * @return SalesforceGroupeMatchFonction
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime $updatedAt
     * @return SalesforceGroupeMatchFonction
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}