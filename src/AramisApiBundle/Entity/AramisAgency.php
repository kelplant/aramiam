<?php
namespace AramisApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="core_app_aramis_agency_data")
 * @ORM\Entity(repositoryClass="AramisApiBundle\Repository\AramisAgencyRepository")
 */
class AramisAgency
{
    /** @ORM\Id()
     * @var string
     * @ORM\Column(type="string")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $cetelemCode;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $lizautoCode;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $label;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $address1;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $zipCode;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $city;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $phone;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $email;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $pointOfSale;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $coordonnees;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $cargarantieId;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $slug;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $isSaleAppointmentsEligible;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $isPurchaseAppointmentsEligible;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $isPurchaseSaleAppointmentsEligible;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return AramisAgency
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getCetelemCode()
    {
        return $this->cetelemCode;
    }

    /**
     * @param string $cetelemCode
     * @return AramisAgency
     */
    public function setCetelemCode($cetelemCode)
    {
        $this->cetelemCode = $cetelemCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getLizautoCode()
    {
        return $this->lizautoCode;
    }

    /**
     * @param string $lizautoCode
     * @return AramisAgency
     */
    public function setLizautoCode($lizautoCode)
    {
        $this->lizautoCode = $lizautoCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $label
     * @return AramisAgency
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return string
     */
    public function getAddress1()
    {
        return $this->address1;
    }

    /**
     * @param string $address1
     * @return AramisAgency
     */
    public function setAddress1($address1)
    {
        $this->address1 = $address1;
        return $this;
    }

    /**
     * @return string
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * @param string $zipCode
     * @return AramisAgency
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     * @return AramisAgency
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     * @return AramisAgency
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
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
     * @return AramisAgency
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getPointOfSale()
    {
        return $this->pointOfSale;
    }

    /**
     * @param string $pointOfSale
     * @return AramisAgency
     */
    public function setPointOfSale($pointOfSale)
    {
        $this->pointOfSale = $pointOfSale;
        return $this;
    }

    /**
     * @return string
     */
    public function getCoordonnees()
    {
        return $this->coordonnees;
    }

    /**
     * @param string $coordonnees
     * @return AramisAgency
     */
    public function setCoordonnees($coordonnees)
    {
        $this->coordonnees = $coordonnees;
        return $this;
    }

    /**
     * @return string
     */
    public function getCargarantieId()
    {
        return $this->cargarantieId;
    }

    /**
     * @param string $cargarantieId
     * @return AramisAgency
     */
    public function setCargarantieId($cargarantieId)
    {
        $this->cargarantieId = $cargarantieId;
        return $this;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     * @return AramisAgency
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return string
     */
    public function getIsSaleAppointmentsEligible()
    {
        return $this->isSaleAppointmentsEligible;
    }

    /**
     * @param string $isSaleAppointmentsEligible
     * @return AramisAgency
     */
    public function setIsSaleAppointmentsEligible($isSaleAppointmentsEligible)
    {
        $this->isSaleAppointmentsEligible = $isSaleAppointmentsEligible;
        return $this;
    }

    /**
     * @return string
     */
    public function getIsPurchaseAppointmentsEligible()
    {
        return $this->isPurchaseAppointmentsEligible;
    }

    /**
     * @param string $isPurchaseAppointmentsEligible
     * @return AramisAgency
     */
    public function setIsPurchaseAppointmentsEligible($isPurchaseAppointmentsEligible)
    {
        $this->isPurchaseAppointmentsEligible = $isPurchaseAppointmentsEligible;
        return $this;
    }

    /**
     * @return string
     */
    public function getIsPurchaseSaleAppointmentsEligible()
    {
        return $this->isPurchaseSaleAppointmentsEligible;
    }

    /**
     * @param string $isPurchaseSaleAppointmentsEligible
     * @return AramisAgency
     */
    public function setIsPurchaseSaleAppointmentsEligible($isPurchaseSaleAppointmentsEligible)
    {
        $this->isPurchaseSaleAppointmentsEligible = $isPurchaseSaleAppointmentsEligible;
        return $this;
    }
}