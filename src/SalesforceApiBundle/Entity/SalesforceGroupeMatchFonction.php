<?php
namespace SalesforceApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @return int
     */
    public function getFonctionId()
    {
        return $this->fonctionId;
    }

    /**
     * @param int $fonctionId
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
}