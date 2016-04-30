<?php
namespace OdigoApiBundle\Entity\ApiObjects\UserBeans;

/**
 * Class UserBean
 * @package OdigoApiBundle\Entity\ApiObjects\UserBeans
 */
class UserBean
{
    /**
     * - minOccurs : 0
     * - nillable : true
     * @var string
     */
    public $activeState;
    /**
     * - maxOccurs : unbounded
     * - minOccurs : 0
     * - nillable : true
     * @var string
     */
    public $agentGroups;
    /**
     * - maxOccurs : unbounded
     * - minOccurs : 0
     * - nillable : true
     * @var string
     */
    public $breaks;
    /**
     * - minOccurs : 0
     * - nillable : true
     * @var string
     */
    public $calendarId;
    /**
     * - minOccurs : 0
     * - nillable : true
     * @var string
     */
    public $ddiNumber;
    /**
     * - minOccurs : 0
     * @var int
     */
    public $disruptionDuration;
    /**
     * - minOccurs : 0
     * - nillable : true
     * @var string
     */
    public $email;
    /**
     * - minOccurs : 0
     * @var boolean
     */
    public $enable2WaysSwitch;
    /**
     * - minOccurs : 0
     * @var boolean
     */
    public $enableCallBack;
    /**
     * - minOccurs : 0
     * @var boolean
     */
    public $enableConference;
    /**
     * - minOccurs : 0
     * @var boolean
     */
    public $enableOutCall;
    /**
     * - minOccurs : 0
     * @var boolean
     */
    public $enableRecording;
    /**
     * - minOccurs : 0
     * - nillable : true
     * @var string
     */
    public $firstName;
    /**
     * - minOccurs : 0
     * @var int
     */
    public $languageId;
    /**
     * - minOccurs : 0
     * - nillable : true
     * @var string
     */
    public $loginTel;
    /**
     * - minOccurs : 0
     * - nillable : true
     * @var string
     */
    public $name;
    /**
     * - minOccurs : 0
     * - nillable : true
     * @var string
     */
    public $password;
    /**
     * - maxOccurs : unbounded
     * - minOccurs : 0
     * - nillable : true
     * @var UserSkillBean
     */
    public $skills;
    /**
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