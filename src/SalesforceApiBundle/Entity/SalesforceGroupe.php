<?php
namespace SalesforceApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="salesforce_groupe")
 * @ORM\Entity(repositoryClass="SalesforceApiBundle\Repository\SalesforceGroupeRepository")
 */
class SalesforceGroupe
{
    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(type="string", unique=true)
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=30, unique=true)
     */
    protected $groupeId;

    /**
     * @var string
     * @ORM\Column(type="string", length=100, unique=true)
     */
    protected $groupeName;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return SalesforceProfile
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getGroupeId()
    {
        return $this->groupeId;
    }

    /**
     * @param string $groupeId
     * @return SalesforceProfile
     */
    public function setGroupeId($groupeId)
    {
        $this->groupeId = $groupeId;
        return $this;
    }

    /**
     * @return string
     */
    public function getGroupeName()
    {
        return $this->groupeName;
    }

    /**
     * @param string $groupeName
     * @return SalesforceProfile
     */
    public function setGroupeName($groupeName)
    {
        $this->groupeName = $groupeName;
        return $this;
    }
}