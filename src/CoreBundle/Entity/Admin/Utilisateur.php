<?php
namespace CoreBundle\Entity\Admin;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * Class Utilisateur
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\Admin\UtilisateurRepository")
 * @ORM\Table(name="core_admin_utilisateurs", uniqueConstraints={@ORM\UniqueConstraint(name="utilisateur_unique", columns={"name", "surname"})})
 */
class Utilisateur extends AbstractPerson
{
    /**
     * @var string
     * @ORM\Column(type="string", length=100)
     */
    protected $viewName;

    /**
     * @var string
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $email;

    /**
     * @var string
     * @ORM\Column(type="string", length=100)
     */
    protected $mainPassword;

    /**
     * @var string
     * @ORM\Column(type="integer", length=10, nullable=true, options={"default":null})
     */
    protected $idCandidat;

    /**
     * @var string
     * @ORM\Column(type="integer", nullable=true, options={"default":0})
     */
    protected $isCreateInOdigo;

    /**
     * @var string
     * @ORM\Column(type="integer", nullable=true, options={"default":0})
     */
    protected $isCreateInGmail;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true, options={"default":null})
     */
    protected $isCreateInSalesforce;

    /**
     * @var string
     * @ORM\Column(type="integer", nullable=true, options={"default":0})
     */
    protected $isCreateInRobusto;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true, options={"default":null})
     */
    protected $isCreateInWindows;

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
     * @return string
     */
    public function getViewName()
    {
        return $this->viewName;
    }

    /**
     * @param string $viewName
     * @return Utilisateur
     */
    public function setViewName($viewName)
    {
        $this->viewName = $viewName;
        return $this;
    }

    /**
     * @return string
     */
    public function getIsCreateInOdigo()
    {
        return $this->isCreateInOdigo;
    }

    /**
     * @param string $isCreateInOdigo
     * @return Utilisateur
     */
    public function setIsCreateInOdigo($isCreateInOdigo)
    {
        $this->isCreateInOdigo = $isCreateInOdigo;
        return $this;
    }

    /**
     * @return string
     */
    public function getIsCreateInGmail()
    {
        return $this->isCreateInGmail;
    }

    /**
     * @param string $isCreateInGmail
     * @return Utilisateur
     */
    public function setIsCreateInGmail($isCreateInGmail)
    {
        $this->isCreateInGmail = $isCreateInGmail;
        return $this;
    }

    /**
     * @return string
     */
    public function getIsCreateInSalesforce()
    {
        return $this->isCreateInSalesforce;
    }

    /**
     * @param string $isCreateInSalesforce
     * @return Utilisateur
     */
    public function setIsCreateInSalesforce($isCreateInSalesforce)
    {
        $this->isCreateInSalesforce = $isCreateInSalesforce;
        return $this;
    }

    /**
     * @return string
     */
    public function getIsCreateInRobusto()
    {
        return $this->isCreateInRobusto;
    }

    /**
     * @param string $isCreateInRobusto
     * @return Utilisateur
     */
    public function setIsCreateInRobusto($isCreateInRobusto)
    {
        $this->isCreateInRobusto = $isCreateInRobusto;
        return $this;
    }

    /**
     * @return string
     */
    public function getIdCandidat()
    {
        return $this->idCandidat;
    }

    /**
     * @param string $idCandidat
     * @return Utilisateur
     */
    public function setIdCandidat($idCandidat)
    {
        $this->idCandidat = $idCandidat;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return Utilisateur
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getMainPassword()
    {
        return $this->mainPassword;
    }

    /**
     * @param string $mainPassword
     * @return Utilisateur
     */
    public function setMainPassword($mainPassword)
    {
        $this->mainPassword = $mainPassword;
        return $this;
    }

    /**
     * @return string
     */
    public function getIsCreateInWindows()
    {
        return $this->isCreateInWindows;
    }

    /**
     * @param string $isCreateInWindows
     * @return Utilisateur
     */
    public function setIsCreateInWindows($isCreateInWindows)
    {
        $this->isCreateInWindows = $isCreateInWindows;
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
     * @return Utilisateur
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
     * @return Utilisateur
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}