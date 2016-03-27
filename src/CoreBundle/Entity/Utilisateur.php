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
 * @ORM\Entity(repositoryClass="CoreBundle\Entity\Repository\UtilisateurRepository")
 * @ORM\Table(name="utilisateur")
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
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $odigoPhoneNumber;

    /**
     * @var string
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $redirectPhoneNumber;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $odigoExtension;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $startDate;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $robustoProfil;

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
    public function getOdigoPhoneNumber()
    {
        return $this->odigoPhoneNumber;
    }

    /**
     * @param string $odigoPhoneNumber
     * @return Utilisateur
     */
    public function setOdigoPhoneNumber($odigoPhoneNumber)
    {
        $this->odigoPhoneNumber = $odigoPhoneNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getRedirectPhoneNumber()
    {
        return $this->redirectPhoneNumber;
    }

    /**
     * @param string $redirectPhoneNumber
     * @return Utilisateur
     */
    public function setRedirectPhoneNumber($redirectPhoneNumber)
    {
        $this->redirectPhoneNumber = $redirectPhoneNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getOdigoExtension()
    {
        return $this->odigoExtension;
    }

    /**
     * @param string $odigoExtension
     * @return Utilisateur
     */
    public function setOdigoExtension($odigoExtension)
    {
        $this->odigoExtension = $odigoExtension;
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
     * @return mixed
     */
    public function getIsCreateInOdigo()
    {
        return $this->isCreateInOdigo;
    }

    /**
     * @param mixed $isCreateInOdigo
     * @return Utilisateur
     */
    public function setIsCreateInOdigo($isCreateInOdigo)
    {
        $this->isCreateInOdigo = $isCreateInOdigo;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIsCreateInGmail()
    {
        return $this->isCreateInGmail;
    }

    /**
     * @param mixed $isCreateInGmail
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