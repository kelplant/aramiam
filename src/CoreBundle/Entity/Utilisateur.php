<?php
/**
 * Created by PhpStorm.
 * User: Xavier
 * Date: 24/03/2016
 * Time: 18:26
 */
namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Utilisateur
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\UtilisateurRepository")
 * @ORM\Table(name="core_utilisateur")
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
     * @ORM\Column(type="string")
     */

    protected $name;
    /**
     * @var string
     * @ORM\Column(type="string"))
     */

    protected $surname;
    /**
     * @var string
     * @ORM\Column(type="string"))
     */

    protected $viewName;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $email;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $startDate;

    /**
     * @ORM\ManyToOne(targetEntity="Agence")
     */
    protected $agence;

    /**
     * @ORM\ManyToOne(targetEntity="Service")
     */
    protected $service;

    /**
     * @ORM\ManyToOne(targetEntity="Fonction")
     */
    protected $fonction;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $isCreateInOdigo;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $isCreateInGmail;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $isCreateInSalesforce;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $isCreateInRobusto;

    /**
     * @var string
     * @ORM\Column(type="boolean")
     */
    protected $isActive;

    /**
     * @var string
     * @ORM\Column(type="boolean")
     */
    protected $isDelete;

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
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param string $startDate
     * @return Utilisateur
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAgence()
    {
        return $this->agence;
    }

    /**
     * @param mixed $agence
     * @return Utilisateur
     */
    public function setAgence($agence)
    {
        $this->agence = $agence;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param mixed $service
     * @return Utilisateur
     */
    public function setService($service)
    {
        $this->service = $service;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFonction()
    {
        return $this->fonction;
    }

    /**
     * @param mixed $fonction
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
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * @param string $isActive
     * @return Utilisateur
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
        return $this;
    }

    /**
     * @return string
     */
    public function getIsDelete()
    {
        return $this->isDelete;
    }

    /**
     * @param string $isDelete
     * @return Utilisateur
     */
    public function setIsDelete($isDelete)
    {
        $this->isDelete = $isDelete;
        return $this;
    }
}