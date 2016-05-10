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
     * @var DateTime|string
     * @ORM\Column(type="string", nullable=false)
     */
    public $createdDate;

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
        if ($createdDate == null) {
            $createdDate = new DateTime();
            $createdDate = $createdDate->format('Y-m-d H:m:s');
        }
        $this->createdDate = $createdDate;
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
     * @return Candidat
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
     * @return Candidat
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}