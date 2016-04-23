<?php
namespace SalesforceApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * Class Salesforce
 * @ORM\Entity(repositoryClass="SalesforceApiBundle\Repository\SalesforceRepository")
 * @ORM\Table(name="salesforce_user_link")
 */
class Salesforce
{
    /** @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="integer")
     */
    protected $user;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $salesforceProfil;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Salesforce
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param string $user
     * @return Salesforce
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return string
     */
    public function getSalesforceProfil()
    {
        return $this->salesforceProfil;
    }

    /**
     * @param string $salesforceProfil
     * @return Salesforce
     */
    public function setSalesforceProfil($salesforceProfil)
    {
        $this->salesforceProfil = $salesforceProfil;
        return $this;
    }
}
