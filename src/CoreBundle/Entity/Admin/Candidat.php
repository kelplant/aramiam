<?php
namespace CoreBundle\Entity\Admin;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * Class Candidat
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\Admin\CandidatRepository")
 * @ORM\Table(name="core_admin_candidats")
 */
class Candidat extends AbstractPerson
{
    /**
     * @var DateTime
     * @ORM\Column(type="date", nullable=false)
     */
    public $createdDate;

    /**
     * @return DateTime
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * @param DateTime $createdDate
     * @return Candidat
     */
    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;
        return $this;
    }
}