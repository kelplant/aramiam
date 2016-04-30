<?php
namespace OdigoApiBundle\Entity\UserBeans;

/**
 * Class UserBean
 * @package OdigoApiBundle\Entity\UserBeans
 */
class UserBean
{
    /**
     * The activeState
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * - nillable : true
     * @var string
     */
    public $activeState;
    /**
     * The agentGroups
     * Meta informations extracted from the WSDL
     * - maxOccurs : unbounded
     * - minOccurs : 0
     * - nillable : true
     * @var string
     */
    public $agentGroups;
    /**
     * The breaks
     * Meta informations extracted from the WSDL
     * - maxOccurs : unbounded
     * - minOccurs : 0
     * - nillable : true
     * @var string
     */
    public $breaks;
    /**
     * The calendarId
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * - nillable : true
     * @var string
     */
    public $calendarId;
    /**
     * The ddiNumber
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * - nillable : true
     * @var string
     */
    public $ddiNumber;
    /**
     * The disruptionDuration
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var int
     */
    public $disruptionDuration;
    /**
     * The email
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * - nillable : true
     * @var string
     */
    public $email;
    /**
     * The enable2WaysSwitch
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var boolean
     */
    public $enable2WaysSwitch;
    /**
     * The enableCallBack
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var boolean
     */
    public $enableCallBack;
    /**
     * The enableConference
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var boolean
     */
    public $enableConference;
    /**
     * The enableOutCall
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var boolean
     */
    public $enableOutCall;
    /**
     * The enableRecording
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var boolean
     */
    public $enableRecording;
    /**
     * The firstName
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * - nillable : true
     * @var string
     */
    public $firstName;
    /**
     * The languageId
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var int
     */
    public $languageId;
    /**
     * The loginTel
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * - nillable : true
     * @var string
     */
    public $loginTel;
    /**
     * The name
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * - nillable : true
     * @var string
     */
    public $name;
    /**
     * The password
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * - nillable : true
     * @var string
     */
    public $password;
    /**
     * The skills
     * Meta informations extracted from the WSDL
     * - maxOccurs : unbounded
     * - minOccurs : 0
     * - nillable : true
     * @var UserSkillBean
     */
    public $skills;
    /**
     * The transfertDDIAuthorized
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var boolean
     */
    public $transfertDDIAuthorized;
    /**
     * The userId
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * - nillable : true
     * @var string
     */
    public $userId;
    /**
     * The wrapupTime
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var int
     */
    public $wrapupTime;

    /**
     * UserBean constructor.
     * @param string $activeState
     * @param string $agentGroups
     * @param string $breaks
     * @param string $calendarId
     * @param string $ddiNumber
     * @param int $disruptionDuration
     * @param string $email
     * @param bool $enable2WaysSwitch
     * @param bool $enableCallBack
     * @param bool $enableConference
     * @param bool $enableOutCall
     * @param bool $enableRecording
     * @param string $firstName
     * @param int $languageId
     * @param string $loginTel
     * @param string $name
     * @param string $password
     * @param UserSkillBean $skills
     * @param bool $transfertDDIAuthorized
     * @param string $userId
     * @param int $wrapupTime
     */
    public function __construct($activeState = null, $agentGroups = null, $breaks = null, $calendarId = null, $ddiNumber = null, $disruptionDuration = null, $email = null, $enable2WaysSwitch = null, $enableCallBack = null, $enableConference = null, $enableOutCall = null, $enableRecording = null, $firstName = null, $languageId = null, $loginTel = null, $name = null, $password = null, UserSkillBean $skills = null, $transfertDDIAuthorized = null, $userId = null, $wrapupTime = null)
    {
        $this->activeState = $activeState;
        $this->agentGroups = $agentGroups;
        $this->breaks = $breaks;
        $this->calendarId = $calendarId;
        $this->ddiNumber = $ddiNumber;
        $this->disruptionDuration = $disruptionDuration;
        $this->email = $email;
        $this->enable2WaysSwitch = $enable2WaysSwitch;
        $this->enableCallBack = $enableCallBack;
        $this->enableConference = $enableConference;
        $this->enableOutCall = $enableOutCall;
        $this->enableRecording = $enableRecording;
        $this->firstName = $firstName;
        $this->languageId = $languageId;
        $this->loginTel = $loginTel;
        $this->name = $name;
        $this->password = $password;
        $this->skills = $skills;
        $this->transfertDDIAuthorized = $transfertDDIAuthorized;
        $this->userId = $userId;
        $this->wrapupTime = $wrapupTime;
    }

    /**
     * @return string
     */
    public function getActiveState()
    {
        return $this->activeState;
    }

    /**
     * @param string $activeState
     * @return UserBean
     */
    public function setActiveState($activeState)
    {
        $this->activeState = $activeState;
        return $this;
    }

    /**
     * @return string
     */
    public function getAgentGroups()
    {
        return $this->agentGroups;
    }

    /**
     * @param string $agentGroups
     * @return UserBean
     */
    public function setAgentGroups($agentGroups)
    {
        $this->agentGroups = $agentGroups;
        return $this;
    }

    /**
     * @return string
     */
    public function getBreaks()
    {
        return $this->breaks;
    }

    /**
     * @param string $breaks
     * @return UserBean
     */
    public function setBreaks($breaks)
    {
        $this->breaks = $breaks;
        return $this;
    }

    /**
     * @return string
     */
    public function getCalendarId()
    {
        return $this->calendarId;
    }

    /**
     * @param string $calendarId
     * @return UserBean
     */
    public function setCalendarId($calendarId)
    {
        $this->calendarId = $calendarId;
        return $this;
    }

    /**
     * @return string
     */
    public function getDdiNumber()
    {
        return $this->ddiNumber;
    }

    /**
     * @param string $ddiNumber
     * @return UserBean
     */
    public function setDdiNumber($ddiNumber)
    {
        $this->ddiNumber = $ddiNumber;
        return $this;
    }

    /**
     * @return int
     */
    public function getDisruptionDuration()
    {
        return $this->disruptionDuration;
    }

    /**
     * @param int $disruptionDuration
     * @return UserBean
     */
    public function setDisruptionDuration($disruptionDuration)
    {
        $this->disruptionDuration = $disruptionDuration;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return UserBean
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isEnable2WaysSwitch()
    {
        return $this->enable2WaysSwitch;
    }

    /**
     * @param boolean $enable2WaysSwitch
     * @return UserBean
     */
    public function setEnable2WaysSwitch($enable2WaysSwitch)
    {
        $this->enable2WaysSwitch = $enable2WaysSwitch;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isEnableCallBack()
    {
        return $this->enableCallBack;
    }

    /**
     * @param boolean $enableCallBack
     * @return UserBean
     */
    public function setEnableCallBack($enableCallBack)
    {
        $this->enableCallBack = $enableCallBack;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isEnableConference()
    {
        return $this->enableConference;
    }

    /**
     * @param boolean $enableConference
     * @return UserBean
     */
    public function setEnableConference($enableConference)
    {
        $this->enableConference = $enableConference;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isEnableOutCall()
    {
        return $this->enableOutCall;
    }

    /**
     * @param boolean $enableOutCall
     * @return UserBean
     */
    public function setEnableOutCall($enableOutCall)
    {
        $this->enableOutCall = $enableOutCall;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isEnableRecording()
    {
        return $this->enableRecording;
    }

    /**
     * @param boolean $enableRecording
     * @return UserBean
     */
    public function setEnableRecording($enableRecording)
    {
        $this->enableRecording = $enableRecording;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return UserBean
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return int
     */
    public function getLanguageId()
    {
        return $this->languageId;
    }

    /**
     * @param int $languageId
     * @return UserBean
     */
    public function setLanguageId($languageId)
    {
        $this->languageId = $languageId;
        return $this;
    }

    /**
     * @return string
     */
    public function getLoginTel()
    {
        return $this->loginTel;
    }

    /**
     * @param string $loginTel
     * @return UserBean
     */
    public function setLoginTel($loginTel)
    {
        $this->loginTel = $loginTel;
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
     * @return UserBean
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return UserBean
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return UserSkillBean
     */
    public function getSkills()
    {
        return $this->skills;
    }

    /**
     * @param UserSkillBean $skills
     * @return UserBean
     */
    public function setSkills($skills)
    {
        $this->skills = $skills;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isTransfertDDIAuthorized()
    {
        return $this->transfertDDIAuthorized;
    }

    /**
     * @param boolean $transfertDDIAuthorized
     * @return UserBean
     */
    public function setTransfertDDIAuthorized($transfertDDIAuthorized)
    {
        $this->transfertDDIAuthorized = $transfertDDIAuthorized;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param string $userId
     * @return UserBean
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return int
     */
    public function getWrapupTime()
    {
        return $this->wrapupTime;
    }

    /**
     * @param int $wrapupTime
     * @return UserBean
     */
    public function setWrapupTime($wrapupTime)
    {
        $this->wrapupTime = $wrapupTime;
        return $this;
    }


}