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
     * @param string $Username
     * @return SalesforceUser
     */
    public function setUsername($Username)
    {
        $this->Username = $Username;
        return $this;
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
     * @param string $FirstName
     * @return SalesforceUser
     */
    public function setFirstName($FirstName)
    {
        $this->FirstName = $FirstName;
        return $this;
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
     * @param string $TimeZoneSidKey
     * @return SalesforceUser
     */
    public function setTimeZoneSidKey($TimeZoneSidKey)
    {
        $this->TimeZoneSidKey = $TimeZoneSidKey;
        return $this;
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
     * @param string $CommunityNickname
     * @return SalesforceUser
     */
    public function setCommunityNickname($CommunityNickname)
    {
        $this->CommunityNickname = $CommunityNickname;
        return $this;
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
     * @param string $LocaleSidKey
     * @return SalesforceUser
     */
    public function setLocaleSidKey($LocaleSidKey)
    {
        $this->LocaleSidKey = $LocaleSidKey;
        return $this;
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
     * @param string $ProfileId
     * @return SalesforceUser
     */
    public function setProfileId($ProfileId)
    {
        $this->ProfileId = $ProfileId;
        return $this;
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
     * @param string $UserPermissionsMobileUser
     * @return SalesforceUser
     */
    public function setUserPermissionsMobileUser($UserPermissionsMobileUser)
    {
        $this->UserPermissionsMobileUser = $UserPermissionsMobileUser;
        return $this;
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
     * @param string $CallCenterId
     * @return SalesforceUser
     */
    public function setCallCenterId($CallCenterId)
    {
        $this->CallCenterId = $CallCenterId;
        return $this;
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
     * @param string $City
     * @return SalesforceUser
     */
    public function setCity($City)
    {
        $this->City = $City;
        return $this;
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
     * @param string $State
     * @return SalesforceUser
     */
    public function setState($State)
    {
        $this->State = $State;
        return $this;
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
     * @param string $Fax
     * @return SalesforceUser
     */
    public function setFax($Fax)
    {
        $this->Fax = $Fax;
        return $this;
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
     * @param string $OdigoCti__Odigo_login__c
     * @return SalesforceUser
     */
    public function setOdigoCtiOdigoLoginC($OdigoCti__Odigo_login__c)
    {
        $this->OdigoCti__Odigo_login__c = $OdigoCti__Odigo_login__c;
        return $this;
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
     * @param string $Phone
     * @return SalesforceUser
     */
    public function setPhone($Phone)
    {
        $this->Phone = $Phone;
        return $this;
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
     * @param string $DepartementRegion__c
     * @return SalesforceUser
     */
    public function setDepartementRegionC($DepartementRegion__c)
    {
        $this->DepartementRegion__c = $DepartementRegion__c;
        return $this;
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
     * @param string $Division
     * @return SalesforceUser
     */
    public function setDivision($Division)
    {
        $this->Division = $Division;
        return $this;
    }
}