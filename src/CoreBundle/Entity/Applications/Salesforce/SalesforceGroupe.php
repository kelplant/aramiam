<?php
namespace CoreBundle\Entity\Applications\Salesforce;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="core_app_salesforce_groupe")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\Applications\Salesforce\SalesforceGroupeRepository")
 */
class SalesforceGroupe
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