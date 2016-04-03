<?php
namespace CoreBundle\Entity\Admin;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * Class Utilisateur
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\Admin\UtilisateurRepository")
 * @ORM\Table(name="core_admin_utilisateurs", uniqueConstraints={@ORM\UniqueConstraint(name="utilisateur_unique", columns={"name", "surname"})})
 */
class Utilisateur
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
     * @ORM\Column(type="string", length=100)
     */
    protected $name;

    /**
     * @var string
     * @ORM\Column(type="string", length=100))
     */
    protected $surname;

    /**
     * @var string
     * @ORM\Column(type="string", length=20))
     */
    protected $civilite;

    /**
     * @var DateTime
     * @ORM\Column(type="date")
     */
    protected $startDate;

    /**
     * @var string
     * @ORM\Column(type="string"), length=50))
     */
    protected $entiteHolding;

    /**
     * @var string
     * @ORM\Column(type="integer"), length=10))
     */
    protected $agence;

    /**
     * @var string
     * @ORM\Column(type="integer", length=10))
     */
    protected $service;

    /**
     * @var string
     * @ORM\Column(type="integer", length=10))
     */
    protected $fonction;

    /**
     * @var string
     * @ORM\Column(type="string", length=30))
     */
    protected $statusPoste;

    /**
     * @var string
     * @ORM\Column(type="string", length=100, nullable=true))
     */
    protected $predecesseur;

    /**
     * @var string
     * @ORM\Column(type="string", length=10))
     */
    protected $responsable;

    /**
     * @var string
     * @ORM\Column(type="string", length=20, nullable=true))
     */
    protected $matriculeRH;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true))
     */
    protected $commentaire;

    /**
     * @var string
     * @ORM\Column(type="integer", length=1)
     */
    protected $isArchived;

    /**
     * @var string
     * @ORM\Column(type="string", length=100)
     */

    protected $viewName;

    /**
     * @var string
     * @ORM\Column(type="integer", length=10, nullable=true)
     */
    protected $idCandidat;

    /**
     * @var string
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $email;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true, options={"default":0})
     */
    protected $isCreateInOdigo;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true, options={"default":0})
     */
    protected $isCreateInGmail;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true, options={"default":0})
     */
    protected $isCreateInSalesforce;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true, options={"default":0})
     */
    protected $isCreateInRobusto;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Utilisateur
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Utilisateur
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     * @return Utilisateur
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
        return $this;
    }

    /**
     * @return string
     */
    public function getCivilite()
    {
        return $this->civilite;
    }

    /**
     * @param string $civilite
     * @return Utilisateur
     */
    public function setCivilite($civilite)
    {
        $this->civilite = $civilite;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param DateTime $startDate
     * @return Utilisateur
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getEntiteHolding()
    {
        return $this->entiteHolding;
    }

    /**
     * @param string $entiteHolding
     * @return Utilisateur
     */
    public function setEntiteHolding($entiteHolding)
    {
        $this->entiteHolding = $entiteHolding;
        return $this;
    }

    /**
     * @return string
     */
    public function getAgence()
    {
        return $this->agence;
    }

    /**
     * @param string $agence
     * @return Utilisateur
     */
    public function setAgence($agence)
    {
        $this->agence = $agence;
        return $this;
    }

    /**
     * @return string
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param string $service
     * @return Utilisateur
     */
    public function setService($service)
    {
        $this->service = $service;
        return $this;
    }

    /**
     * @return string
     */
    public function getFonction()
    {
        return $this->fonction;
    }

    /**
     * @param string $fonction
     * @return Utilisateur
     */
    public function setFonction($fonction)
    {
        $this->fonction = $fonction;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatusPoste()
    {
        return $this->statusPoste;
    }

    /**
     * @param string $statusPoste
     * @return Utilisateur
     */
    public function setStatusPoste($statusPoste)
    {
        $this->statusPoste = $statusPoste;
        return $this;
    }

    /**
     * @return string
     */
    public function getPredecesseur()
    {
        return $this->predecesseur;
    }

    /**
     * @param string $predecesseur
     * @return Utilisateur
     */
    public function setPredecesseur($predecesseur)
    {
        $this->predecesseur = $predecesseur;
        return $this;
    }

    /**
     * @return string
     */
    public function getResponsable()
    {
        return $this->responsable;
    }

    /**
     * @param string $responsable
     * @return Utilisateur
     */
    public function setResponsable($responsable)
    {
        $this->responsable = $responsable;
        return $this;
    }

    /**
     * @return string
     */
    public function getMatriculeRH()
    {
        return $this->matriculeRH;
    }

    /**
     * @param string $matriculeRH
     * @return Utilisateur
     */
    public function setMatriculeRH($matriculeRH)
    {
        $this->matriculeRH = $matriculeRH;
        return $this;
    }

    /**
     * @return string
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * @param string $commentaire
     * @return Utilisateur
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;
        return $this;
    }

    /**
     * @return string
     */
    public function getIsArchived()
    {
        return $this->isArchived;
    }

    /**
     * @param string $isArchived
     * @return Utilisateur
     */
    public function setIsArchived($isArchived)
    {
        $this->isArchived = $isArchived;
        return $this;
    }

}