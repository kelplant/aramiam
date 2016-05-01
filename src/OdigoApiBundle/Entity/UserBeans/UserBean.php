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
}