<?php
namespace CoreBundle\Entity\Admin;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * @Gedmo\Tree(type="nested")
 * @ORM\Table(name="core_admin_services")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\Admin\ServiceRepository")
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
     * @ORM\Column(type="string", length=100, nullable=true)
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

    /** @var string
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $nameInActiveDirectory;

    /**
     * @var string
     * @ORM\Column(type="integer", length=1, nullable=true, options={"default":0})
     */
    protected $isArchived;

    /** @var int
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $parentService;

    /** @var int
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $parentAgence;

    /** @var int
     * @Gedmo\TreeLeft
     * @ORM\Column(type="integer")
     */
    protected $lft;

    /** @var int
     * @Gedmo\TreeRight
     * @ORM\Column(type="integer")
     */
    protected $rgt;

    /** @var int
     * @Gedmo\TreeLevel
     * @ORM\Column(type="integer")
     */
    protected $lvl;

    /**
     * @Gedmo\TreeRoot
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\Column(type="integer", nullable=true)
     */
    private $root;

    /**
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="Service", inversedBy="children")
     * @ORM\JoinColumn(name="parent", referencedColumnName="id", onDelete="CASCADE")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="Service", mappedBy="parent")
     * @ORM\OrderBy({"lft" = "ASC"})
     */
    private $children;

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
     * @return Service
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
     * @return Service
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

    /**
     * @return integer
     */
    public function getParentAgence()
    {
        return $this->parentAgence;
    }

    /**
     * @param string $parentAgence
     * @return Service
     */
    public function setParentAgence($parentAgence)
    {
        $this->parentAgence = $parentAgence;
        return $this;
    }

    /**
     * @return string
     */
    public function getNameInActiveDirectory()
    {
        return $this->nameInActiveDirectory;
    }

    /**
     * @param string $nameInActiveDirectory
     * @return Service
     */
    public function setNameInActiveDirectory($nameInActiveDirectory)
    {
        $this->nameInActiveDirectory = $nameInActiveDirectory;
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
     * @return Service
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
     * @return Service
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return integer
     */
    public function getParentService()
    {
        return $this->parentService;
    }

    /**
     * @param string $parentService
     * @return Service
     */
    public function setParentService($parentService)
    {
        $this->parentService = $parentService;
        return $this;
    }

    /**
     * @param Service|null $parent
     * @return $this
     */
    public function setParent(Service $parent = null)
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * @return null|Service
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @return mixed
     */
    public function getIsArchived()
    {
        return $this->isArchived;
    }

    /**
     * @param mixed $isArchived
     * @return Service
     */
    public function setIsArchived($isArchived)
    {
        $this->isArchived = $isArchived;
        return $this;
    }
}