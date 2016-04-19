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
     * @var string
     */
    protected $CallCenterId;

    /**
     * @var string
     */
    protected $Street;

    /**
     * @var string
     */
    protected $City;

    /**
     * @var string
     */
    protected $PostalCode;

    /**
     * @var string
     */
    protected $State;

    /**
     * @var string
     */
    protected $ExternalID__c;

    /**
     * @var string
     */
    protected $Fax;

    /**
     * @var string
     */
    protected $Extension;

    /**
     * @var string
     */
    protected $OdigoCti__Odigo_login__c;

    /**
     * @var string
     */
    protected $Telephone_interne__c;

    /**
     * @var string
     */
    protected $Phone;

    /**
     * @var string
     */
    protected $Title;

    /**
     * @var string
     */
    protected $DepartementRegion__c;

    /**
     * @var string
     */
    protected $Department;

    /**
     * @var string
     */
    protected $Division;

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

    /**
     * @return string
     */
    public function getCallCenterId()
    {
        return $this->CallCenterId;
    }

    /**
     * @param string $CallCenterId
     * @return SalesforceUser
     */
    public function setCallCenterId($CallCenterId)
    {
        $this->CallCenterId = $CallCenterId;
        return $this;
    }

    /**
     * @return string
     */
    public function getStreet()
    {
        return $this->Street;
    }

    /**
     * @param string $Street
     * @return SalesforceUser
     */
    public function setStreet($Street)
    {
        $this->Street = $Street;
        return $this;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->City;
    }

    /**
     * @param string $City
     * @return SalesforceUser
     */
    public function setCity($City)
    {
        $this->City = $City;
        return $this;
    }

    /**
     * @return string
     */
    public function getPostalCode()
    {
        return $this->PostalCode;
    }

    /**
     * @param string $PostalCode
     * @return SalesforceUser
     */
    public function setPostalCode($PostalCode)
    {
        $this->PostalCode = $PostalCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->State;
    }

    /**
     * @param string $State
     * @return SalesforceUser
     */
    public function setState($State)
    {
        $this->State = $State;
        return $this;
    }

    /**
     * @return string
     */
    public function getExternalIDC()
    {
        return $this->ExternalID__c;
    }

    /**
     * @param string $ExternalID__c
     * @return SalesforceUser
     */
    public function setExternalIDC($ExternalID__c)
    {
        $this->ExternalID__c = $ExternalID__c;
        return $this;
    }

    /**
     * @return string
     */
    public function getFax()
    {
        return $this->Fax;
    }

    /**
     * @param string $Fax
     * @return SalesforceUser
     */
    public function setFax($Fax)
    {
        $this->Fax = $Fax;
        return $this;
    }

    /**
     * @return string
     */
    public function getExtension()
    {
        return $this->Extension;
    }

    /**
     * @param string $Extension
     * @return SalesforceUser
     */
    public function setExtension($Extension)
    {
        $this->Extension = $Extension;
        return $this;
    }

    /**
     * @return string
     */
    public function getOdigoCtiOdigoLoginC()
    {
        return $this->OdigoCti__Odigo_login__c;
    }

    /**
     * @param string $OdigoCti__Odigo_login__c
     * @return SalesforceUser
     */
    public function setOdigoCtiOdigoLoginC($OdigoCti__Odigo_login__c)
    {
        $this->OdigoCti__Odigo_login__c = $OdigoCti__Odigo_login__c;
        return $this;
    }

    /**
     * @return string
     */
    public function getTelephoneInterneC()
    {
        return $this->Telephone_interne__c;
    }

    /**
     * @param string $Telephone_interne__c
     * @return SalesforceUser
     */
    public function setTelephoneInterneC($Telephone_interne__c)
    {
        $this->Telephone_interne__c = $Telephone_interne__c;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->Phone;
    }

    /**
     * @param string $Phone
     * @return SalesforceUser
     */
    public function setPhone($Phone)
    {
        $this->Phone = $Phone;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->Title;
    }

    /**
     * @param string $Title
     * @return SalesforceUser
     */
    public function setTitle($Title)
    {
        $this->Title = $Title;
        return $this;
    }

    /**
     * @return string
     */
    public function getDepartementRegionC()
    {
        return $this->DepartementRegion__c;
    }

    /**
     * @param string $DepartementRegion__c
     * @return SalesforceUser
     */
    public function setDepartementRegionC($DepartementRegion__c)
    {
        $this->DepartementRegion__c = $DepartementRegion__c;
        return $this;
    }

    /**
     * @return string
     */
    public function getDepartment()
    {
        return $this->Department;
    }

    /**
     * @param string $Department
     * @return SalesforceUser
     */
    public function setDepartment($Department)
    {
        $this->Department = $Department;
        return $this;
    }

    /**
     * @return string
     */
    public function getDivision()
    {
        return $this->Division;
    }

    /**
     * @param string $Division
     * @return SalesforceUser
     */
    public function setDivision($Division)
    {
        $this->Division = $Division;
        return $this;
    }
}