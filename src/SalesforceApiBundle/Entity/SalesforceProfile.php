<?php
namespace SalesforceApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="salesforce_profile")
 * @ORM\Entity(repositoryClass="SalesforceApiBundle\Repository\SalesforceProfileRepository")
 */
class SalesforceProfile
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
    protected $profileId;

    /**
     * @var string
     * @ORM\Column(type="string", length=100, unique=true)
     */
    protected $profileName;

    /**
     * @var string
     * @ORM\Column(type="string", length=30, unique=false)
     */
    protected $userLicenseId;

    /**
     * @var string
     * @ORM\Column(type="string", length=30, unique=false)
     */
    protected $userType;

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
    public function getProfileId()
    {
        return $this->profileId;
    }

    /**
     * @param string $profileId
     * @return SalesforceProfile
     */
    public function setProfileId($profileId)
    {
        $this->profileId = $profileId;
        return $this;
    }

    /**
     * @return string
     */
    public function getProfileName()
    {
        return $this->profileName;
    }

    /**
     * @param string $profileName
     * @return SalesforceProfile
     */
    public function setProfileName($profileName)
    {
        $this->profileName = $profileName;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserLicenseId()
    {
        return $this->userLicenseId;
    }

    /**
     * @param string $userLicenseId
     * @return SalesforceProfile
     */
    public function setUserLicenseId($userLicenseId)
    {
        $this->userLicenseId = $userLicenseId;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserType()
    {
        return $this->userType;
    }

    /**
     * @param string $userType
     * @return SalesforceProfile
     */
    public function setUserType($userType)
    {
        $this->userType = $userType;
        return $this;
    }
}