<?php
namespace ActiveDirectoryApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="active_directory_organisation_units")
 * @ORM\Entity(repositoryClass="ActiveDirectoryApiBundle\Repository\ActiveDirectoryOrganisationUnitRepository")
 */
class ActiveDirectoryOrganisationUnit
{
    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(type="string", unique=true)
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=100, unique=false)
     */
    protected $name;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $dn;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $agence;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $service;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $fonction;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return ActiveDirectoryOrganisationUnit
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
     * @return ActiveDirectoryOrganisationUnit
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getDn()
    {
        return $this->dn;
    }

    /**
     * @param string $dn
     * @return ActiveDirectoryOrganisationUnit
     */
    public function setDn($dn)
    {
        $this->dn = $dn;
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
     * @return ActiveDirectoryOrganisationUnit
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
     * @return ActiveDirectoryOrganisationUnit
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
     * @return ActiveDirectoryOrganisationUnit
     */
    public function setFonction($fonction)
    {
        $this->fonction = $fonction;
        return $this;
    }
}