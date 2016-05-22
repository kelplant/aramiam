<?php
namespace AramisApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * Class AramisRobusto
 * @ORM\Entity()
 * @ORM\Table(name="aramis_robusto_user_link")
 */
class AramisRobusto
{
    /** @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="integer")
     */
    protected $user;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $robustoProfil;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $robustoUserName;

    /**
     * @var DateTime
     * @ORM\Column(type="date", nullable=true)
     */
    protected $robustoEndDate;

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
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return AramisRobusto
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param string $user
     * @return AramisRobusto
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return string
     */
    public function getRobustoProfil()
    {
        return $this->robustoProfil;
    }

    /**
     * @param string $robustoProfil
     * @return AramisRobusto
     */
    public function setRobustoProfil($robustoProfil)
    {
        $this->robustoProfil = $robustoProfil;
        return $this;
    }

    /**
     * @return string
     */
    public function getRobustoEndDate()
    {
        return $this->robustoEndDate;
    }

    /**
     * @param string $robustoEndDate
     * @return AramisRobusto
     */
    public function setRobustoEndDate($robustoEndDate)
    {
        $this->robustoEndDate = $robustoEndDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getRobustoUserName()
    {
        return $this->robustoUserName;
    }

    /**
     * @param string $robustoUserName
     * @return AramisRobusto
     */
    public function setRobustoUserName($robustoUserName)
    {
        $this->robustoUserName = $robustoUserName;
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
     * @return AramisRobusto
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
     * @return AramisRobusto
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}