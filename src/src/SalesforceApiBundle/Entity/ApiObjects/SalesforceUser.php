<?php
namespace SalesforceApiBundle\Entity\ApiObjects;

/**
 * Class SalesforceUser
 * @package SalesforceApiBundle\Entity\ApiObjects
 */
class SalesforceUser
{
    /**
     *
     * @var string
     */
    public $Username;

    /**
     * @var string
     */
    public $LastName;

    /**
     * @var string
     */
    public $FirstName;

    /**
     * @var string
     */
    public $Email;

    /**
     * @var string
     */
    public $TimeZoneSidKey;

    /**
     * @var string
     */
    public $Alias;

    /**
     * @var string
     */
    public $CommunityNickname;

    /**
     * @var string
     */
    public $IsActive;

    /**
     * @var string
     */
    public $LocaleSidKey;

    /**
     * @var string
     */
    public $EmailEncodingKey;

    /**
     * @var string
     */
    public $ProfileId;

    /**
     * @var string
     */
    public $LanguageLocaleKey;

    /**
     * @var string
     */
    public $UserPermissionsMobileUser;

    /**
     * @var string
     */
    public $UserPreferencesDisableAutoSubForFeeds;

    /**
     * @var string
     */
    public $CallCenterId;

    /**
     * @var string
     */
    public $Street;

    /**
     * @var string
     */
    public $City;

    /**
     * @var string
     */
    public $PostalCode;

    /**
     * @var string
     */
    public $State;

    /**
     * @var string
     */
    public $ExternalID__c;

    /**
     * @var string
     */
    public $Fax;

    /**
     * @var string
     */
    public $Extension;

    /**
     * @var string
     */
    public $OdigoCti__Odigo_login__c;

    /**
     * @var string
     */
    public $Telephone_interne__c;

    /**
     * @var string
     */
    public $Phone;

    /**
     * @var string
     */
    public $Title;

    /**
     * @var string
     */
    public $Department;

    /**
     * @var string
     */
    public $Division;

    /**
     * @var string
     */
    public $UserPermissionsSupportUser;

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

    /**
     * @param string $UserPermissionsSupportUser
     * @return SalesforceUser
     */
    public function setUserPermissionsSupportUser($UserPermissionsSupportUser)
    {
        $this->UserPermissionsSupportUser = $UserPermissionsSupportUser;
        return $this;
    }
}