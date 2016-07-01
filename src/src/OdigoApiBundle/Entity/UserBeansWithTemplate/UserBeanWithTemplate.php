<?php
namespace OdigoApiBundle\Entity\UserBeansWithTemplate;

/**
 * Class UserBeanWithTemplate
 * @package OdigoApiBundle\Entity\UserBeansWithTemplate
 */
class UserBeanWithTemplate
{
    /**
     * The active
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var int
     */
    public $active;
    /**
     * The data
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * - nillable : true
     * @var string
     */
    public $data;
    /**
     * The ddiNumber
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * - nillable : true
     * @var string
     */
    public $ddiNumber;
    /**
     * The directAccessCode
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * - nillable : true
     * @var string
     */
    public $directAccessCode;
    /**
     * The firstName
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * - nillable : true
     * @var string
     */
    public $firstName;
    /**
     * The language
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var int
     */
    public $language;
    /**
     * The listAgentGroup
     * Meta informations extracted from the WSDL
     * - maxOccurs : unbounded
     * - minOccurs : 0
     * - nillable : true
     * @var string
     */
    public $listAgentGroup;
    /**
     * The listSkill
     * Meta informations extracted from the WSDL
     * - maxOccurs : unbounded
     * - minOccurs : 0
     * - nillable : true
     * @var UserSkillBeanWithTemplate
     */
    public $listSkill;
    /**
     * The listTemplate
     * Meta informations extracted from the WSDL
     * - maxOccurs : unbounded
     * - minOccurs : 0
     * - nillable : true
     * @var string
     */
    public $listTemplate;
    /**
     * The mail
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * - nillable : true
     * @var string
     */
    public $mail;
    /**
     * The name
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * - nillable : true
     * @var string
     */
    public $name;
    /**
     * The overloadGroup
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var boolean
     */
    public $overloadGroup;
    /**
     * The overloadTemplate
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var boolean
     */
    public $overloadTemplate;
    /**
     * The password
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * - nillable : true
     * @var string
     */
    public $password;
    /**
     * The phoneLoginNumber
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * - nillable : true
     * @var string
     */
    public $phoneLoginNumber;
    /**
     * The phoneLoginPassword
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * - nillable : true
     * @var string
     */
    public $phoneLoginPassword;
    /**
     * The templateId
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * - nillable : true
     * @var string
     */
    public $templateId;
    /**
     * The timeZone
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * - nillable : true
     * @var string
     */
    public $timeZone;
    /**
     * The userId
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * - nillable : true
     * @var string
     */
    public $userId;

    /**
     * UserBeanWithTemplate constructor.
     * @param int $active
     * @param string $data
     * @param string $ddiNumber
     * @param string $directAccessCode
     * @param string $firstName
     * @param int $language
     * @param string $listAgentGroup
     * @param UserSkillBeanWithTemplate $listSkill
     * @param string $listTemplate
     * @param string $mail
     * @param string $name
     * @param bool $overloadGroup
     * @param bool $overloadTemplate
     * @param string $password
     * @param string $phoneLoginNumber
     * @param string $phoneLoginPassword
     * @param string $templateId
     * @param string $timeZone
     * @param string $userId
     */
    public function __construct($active = null, $data = null, $ddiNumber = null, $directAccessCode = null, $firstName = null, $language = null, $listAgentGroup = null, UserSkillBeanWithTemplate $listSkill = null, $listTemplate = null, $mail = null, $name = null, $overloadGroup = null, $overloadTemplate = null, $password = null, $phoneLoginNumber = null, $phoneLoginPassword = null, $templateId = null, $timeZone = null, $userId = null)
    {
        $this->active = $active;
        $this->data = $data;
        $this->ddiNumber = $ddiNumber;
        $this->directAccessCode = $directAccessCode;
        $this->firstName = $firstName;
        $this->language = $language;
        $this->listAgentGroup = $listAgentGroup;
        $this->listSkill = $listSkill;
        $this->listTemplate = $listTemplate;
        $this->mail = $mail;
        $this->name = $name;
        $this->overloadGroup = $overloadGroup;
        $this->overloadTemplate = $overloadTemplate;
        $this->password = $password;
        $this->phoneLoginNumber = $phoneLoginNumber;
        $this->phoneLoginPassword = $phoneLoginPassword;
        $this->templateId = $templateId;
        $this->timeZone = $timeZone;
        $this->userId = $userId;
    }
}