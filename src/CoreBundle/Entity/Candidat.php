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
 * Class Candidat
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\CandidatRepository")
 * @ORM\Table(name="core_candidat")
 */
class Candidat
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
     * @var string
     * @ORM\Column(type="date")
     */
    protected $startDate;

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
     * @ORM\Column(type="string", length=10))
     */
    protected $responsable;

    /**
     * @var string
     * @ORM\Column(type="string", length=20))
     */
    protected $matriculeRH;

    /**
     * @var string
     * @ORM\Column(type="boolean")
     */
    protected $isArchived;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Candidat
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
     * @return Candidat
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
     * @return Candidat
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
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
     * @return Candidat
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
     * @return Candidat
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
     * @return Candidat
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
     * @return Candidat
     */
    public function setFonction($fonction)
    {
        $this->fonction = $fonction;
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
     * @return Candidat
     */
    public function setResponsable($responsable)
    {
        $this->responsable = $responsable;
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
     * @return Candidat
     */
    public function setIsArchived($isArchived)
    {
        $this->isArchived = $isArchived;
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
     * @return Candidat
     */
    public function setCivilite($civilite)
    {
        $this->civilite = $civilite;
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
     * @return Candidat
     */
    public function setMatriculeRH($matriculeRH)
    {
        $this->matriculeRH = $matriculeRH;
        return $this;
    }

}