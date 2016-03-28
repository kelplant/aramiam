<?php
/**
     * Created by PhpStorm.
     * User: Xavier
     * Date: 26/03/2016
     * Time: 02:24
     */
namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="core_service")
 * @ORM\Entity(repositoryClass="CoreBundle\Entity\Repository\ServiceRepository")
 */
class Service
{
    /** @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /** @var string
     * @ORM\Column(name="service_name", type="string", length=100, nullable=false, unique=true)
     */
    protected $name;

    /** @var string
     * @ORM\Column(type="string", length=100)
     */
    protected $shortName;

    /** @var string
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $nameInCompany;

    /** @var string
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $nameInOdigo;

    /** @var string
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $nameInSalesforce;

    /** @var string
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $nameInZendesk;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Service
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
     * @return Agence
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getShortName()
    {
        return $this->shortName;
    }

    /**
     * @param string $shortName
     * @return Agence
     */
    public function setShortName($shortName)
    {
        $this->shortName = $shortName;
        return $this;
    }

    /**
     * @return string
     */
    public function getNameInCompany()
    {
        return $this->nameInCompany;
    }

    /**
     * @param string $nameInCompany
     * @return Service
     */
    public function setNameInCompany($nameInCompany)
    {
        $this->nameInCompany = $nameInCompany;
        return $this;
    }

    /**
     * @return string
     */
    public function getNameInOdigo()
    {
        return $this->nameInOdigo;
    }

    /**
     * @param string $nameInOdigo
     * @return Service
     */
    public function setNameInOdigo($nameInOdigo)
    {
        $this->nameInOdigo = $nameInOdigo;
        return $this;
    }

    /**
     * @return string
     */
    public function getNameInSalesforce()
    {
        return $this->nameInSalesforce;
    }

    /**
     * @param string $nameInSalesforce
     * @return Service
     */
    public function setNameInSalesforce($nameInSalesforce)
    {
        $this->nameInSalesforce = $nameInSalesforce;
        return $this;
    }

    /**
     * @return string
     */
    public function getNameInZendesk()
    {
        return $this->nameInZendesk;
    }

    /**
     * @param string $nameInZendesk
     * @return Service
     */
    public function setNameInZendesk($nameInZendesk)
    {
        $this->nameInZendesk = $nameInZendesk;
        return $this;
    }
}