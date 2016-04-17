<?php
namespace CoreBundle\Entity\Applications\Salesforce;

/**
 * Class SalesforceUser
 * @package CoreBundle\Controller\Applications\Salesforce
 */
class SalesforceUser
{
    /**
     *
     * @var string
     */
    protected $Username;

    /**
     * @var string
     */
    protected $LastName;

    /**
     * @var string
     */
    protected $FirstName;

    /**
     * @var string
     */
    protected $Email;

    /**
     * @var string
     */
    protected $TimeZoneSidKey;

    /**
     * @var string
     */
    protected $Alias;

    /**
     * @var string
     */
    protected $CommunityNickname;

    /**
     * @var string
     */
    protected $IsActive;

    /**
     * @var string
     */
    protected $LocaleSidKey;

    /**
     * @var string
     */
    protected $EmailEncodingKey;

    /**
     * @var string
     */
    protected $ProfileId;

    /**
     * @var string
     */
    protected $LanguageLocaleKey;

    /**
     * @var string
     */
    protected $UserPermissionsMobileUser;

    /**
     * @var string
     */
    protected $UserPreferencesDisableAutoSubForFeeds;

    /**
     * SalesforceUser constructor.
     * @param string $Username
     * @param string $LastName
     * @param string $FirstName
     * @param string $Email
     * @param string $TimeZoneSidKey
     * @param string $Alias
     * @param string $CommunityNickname
     * @param string $IsActive
     * @param string $LocaleSidKey
     * @param string $EmailEncodingKey
     * @param string $ProfileId
     * @param string $LanguageLocaleKey
     * @param string $UserPermissionsMobileUser
     * @param string $UserPreferencesDisableAutoSubForFeeds
     */
    public function __construct($Username = null, $LastName = null, $FirstName = null, $Email = null, $TimeZoneSidKey = null, $Alias = null, $CommunityNickname = null, $IsActive = null, $LocaleSidKey = null, $EmailEncodingKey = null, $ProfileId = null, $LanguageLocaleKey = null, $UserPermissionsMobileUser = null, $UserPreferencesDisableAutoSubForFeeds = null)
    {
        $this->Username = $Username;
        $this->LastName = $LastName;
        $this->FirstName = $FirstName;
        $this->Email = $Email;
        $this->TimeZoneSidKey = $TimeZoneSidKey;
        $this->Alias = $Alias;
        $this->CommunityNickname = $CommunityNickname;
        $this->IsActive = $IsActive;
        $this->LocaleSidKey = $LocaleSidKey;
        $this->EmailEncodingKey = $EmailEncodingKey;
        $this->ProfileId = $ProfileId;
        $this->LanguageLocaleKey = $LanguageLocaleKey;
        $this->UserPermissionsMobileUser = $UserPermissionsMobileUser;
        $this->UserPreferencesDisableAutoSubForFeeds = $UserPreferencesDisableAutoSubForFeeds;
    }


    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->Username;
    }

    /**
     * @param string $Username
     * @return SalesforceUser
     */
    public function setUsername($Username)
    {
        $this->Username = $Username;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->LastName;
    }

    /**
     * @param string $LastName
     * @return SalesforceUser
     */
    public function setLastName($LastName)
    {
        $this->LastName = $LastName;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->FirstName;
    }

    /**
     * @param string $FirstName
     * @return SalesforceUser
     */
    public function setFirstName($FirstName)
    {
        $this->FirstName = $FirstName;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->Email;
    }

    /**
     * @param string $Email
     * @return SalesforceUser
     */
    public function setEmail($Email)
    {
        $this->Email = $Email;
        return $this;
    }

    /**
     * @return string
     */
    public function getTimeZoneSidKey()
    {
        return $this->TimeZoneSidKey;
    }

    /**
     * @param string $TimeZoneSidKey
     * @return SalesforceUser
     */
    public function setTimeZoneSidKey($TimeZoneSidKey)
    {
        $this->TimeZoneSidKey = $TimeZoneSidKey;
        return $this;
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return $this->Alias;
    }

    /**
     * @param string $Alias
     * @return SalesforceUser
     */
    public function setAlias($Alias)
    {
        $this->Alias = $Alias;
        return $this;
    }

    /**
     * @return string
     */
    public function getCommunityNickname()
    {
        return $this->CommunityNickname;
    }

    /**
     * @param string $CommunityNickname
     * @return SalesforceUser
     */
    public function setCommunityNickname($CommunityNickname)
    {
        $this->CommunityNickname = $CommunityNickname;
        return $this;
    }

    /**
     * @return string
     */
    public function getIsActive()
    {
        return $this->IsActive;
    }

    /**
     * @param string $IsActive
     * @return SalesforceUser
     */
    public function setIsActive($IsActive)
    {
        $this->IsActive = $IsActive;
        return $this;
    }

    /**
     * @return string
     */
    public function getLocaleSidKey()
    {
        return $this->LocaleSidKey;
    }

    /**
     * @param string $LocaleSidKey
     * @return SalesforceUser
     */
    public function setLocaleSidKey($LocaleSidKey)
    {
        $this->LocaleSidKey = $LocaleSidKey;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmailEncodingKey()
    {
        return $this->EmailEncodingKey;
    }

    /**
     * @param string $EmailEncodingKey
     * @return SalesforceUser
     */
    public function setEmailEncodingKey($EmailEncodingKey)
    {
        $this->EmailEncodingKey = $EmailEncodingKey;
        return $this;
    }

    /**
     * @return string
     */
    public function getProfileId()
    {
        return $this->ProfileId;
    }

    /**
     * @param string $ProfileId
     * @return SalesforceUser
     */
    public function setProfileId($ProfileId)
    {
        $this->ProfileId = $ProfileId;
        return $this;
    }

    /**
     * @return string
     */
    public function getLanguageLocaleKey()
    {
        return $this->LanguageLocaleKey;
    }

    /**
     * @param string $LanguageLocaleKey
     * @return SalesforceUser
     */
    public function setLanguageLocaleKey($LanguageLocaleKey)
    {
        $this->LanguageLocaleKey = $LanguageLocaleKey;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserPermissionsMobileUser()
    {
        return $this->UserPermissionsMobileUser;
    }

    /**
     * @param string $UserPermissionsMobileUser
     * @return SalesforceUser
     */
    public function setUserPermissionsMobileUser($UserPermissionsMobileUser)
    {
        $this->UserPermissionsMobileUser = $UserPermissionsMobileUser;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserPreferencesDisableAutoSubForFeeds()
    {
        return $this->UserPreferencesDisableAutoSubForFeeds;
    }

    /**
     * @param string $UserPreferencesDisableAutoSubForFeeds
     * @return SalesforceUser
     */
    public function setUserPreferencesDisableAutoSubForFeeds($UserPreferencesDisableAutoSubForFeeds)
    {
        $this->UserPreferencesDisableAutoSubForFeeds = $UserPreferencesDisableAutoSubForFeeds;
        return $this;
    }
}