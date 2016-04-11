<?php
namespace CoreBundle\Entity\Admin;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="core_admin_entitesHolding")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\Admin\EntiteHoldingRepository")
 */
class EntiteHolding
{
    /** @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /** @var string
     * @ORM\Column(name="entite_name", type="string", length=100, nullable=false, unique=true)
     */
    protected $name;

    /** @var string
     * @ORM\Column(name="entite_short_name", type="string", length=100, nullable=false, unique=true)
     */
    protected $shortName;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return EntiteHolding
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return EntiteHolding
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
     * @return EntiteHolding
     */
    public function setShortName($shortName)
    {
        $this->shortName = $shortName;
        return $this;
    }
}