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

    /**
     * @return int
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param int $active
     * @return UserBeanWithTemplate
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param string $data
     * @return UserBeanWithTemplate
     */
    public function setData($data)
    {
        $this->data = $data;
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
     * @return UserBeanWithTemplate
     */
    public function setDdiNumber($ddiNumber)
    {
        $this->ddiNumber = $ddiNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getDirectAccessCode()
    {
        return $this->directAccessCode;
    }

    /**
     * @param string $directAccessCode
     * @return UserBeanWithTemplate
     */
    public function setDirectAccessCode($directAccessCode)
    {
        $this->directAccessCode = $directAccessCode;
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
     * @return UserBeanWithTemplate
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return int
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param int $language
     * @return UserBeanWithTemplate
     */
    public function setLanguage($language)
    {
        $this->language = $language;
        return $this;
    }

    /**
     * @return string
     */
    public function getListAgentGroup()
    {
        return $this->listAgentGroup;
    }

    /**
     * @param string $listAgentGroup
     * @return UserBeanWithTemplate
     */
    public function setListAgentGroup($listAgentGroup)
    {
        $this->listAgentGroup = $listAgentGroup;
        return $this;
    }

    /**
     * @return UserSkillBeanWithTemplate
     */
    public function getListSkill()
    {
        return $this->listSkill;
    }

    /**
     * @param UserSkillBeanWithTemplate $listSkill
     * @return UserBeanWithTemplate
     */
    public function setListSkill($listSkill)
    {
        $this->listSkill = $listSkill;
        return $this;
    }

    /**
     * @return string
     */
    public function getListTemplate()
    {
        return $this->listTemplate;
    }

    /**
     * @param string $listTemplate
     * @return UserBeanWithTemplate
     */
    public function setListTemplate($listTemplate)
    {
        $this->listTemplate = $listTemplate;
        return $this;
    }

    /**
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * @param string $mail
     * @return UserBeanWithTemplate
     */
    public function setMail($mail)
    {
        $this->mail = $mail;
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
     * @return UserBeanWithTemplate
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isOverloadGroup()
    {
        return $this->overloadGroup;
    }

    /**
     * @param boolean $overloadGroup
     * @return UserBeanWithTemplate
     */
    public function setOverloadGroup($overloadGroup)
    {
        $this->overloadGroup = $overloadGroup;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isOverloadTemplate()
    {
        return $this->overloadTemplate;
    }

    /**
     * @param boolean $overloadTemplate
     * @return UserBeanWithTemplate
     */
    public function setOverloadTemplate($overloadTemplate)
    {
        $this->overloadTemplate = $overloadTemplate;
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
     * @return UserBeanWithTemplate
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhoneLoginNumber()
    {
        return $this->phoneLoginNumber;
    }

    /**
     * @param string $phoneLoginNumber
     * @return UserBeanWithTemplate
     */
    public function setPhoneLoginNumber($phoneLoginNumber)
    {
        $this->phoneLoginNumber = $phoneLoginNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhoneLoginPassword()
    {
        return $this->phoneLoginPassword;
    }

    /**
     * @param string $phoneLoginPassword
     * @return UserBeanWithTemplate
     */
    public function setPhoneLoginPassword($phoneLoginPassword)
    {
        $this->phoneLoginPassword = $phoneLoginPassword;
        return $this;
    }

    /**
     * @return string
     */
    public function getTemplateId()
    {
        return $this->templateId;
    }

    /**
     * @param string $templateId
     * @return UserBeanWithTemplate
     */
    public function setTemplateId($templateId)
    {
        $this->templateId = $templateId;
        return $this;
    }

    /**
     * @return string
     */
    public function getTimeZone()
    {
        return $this->timeZone;
    }

    /**
     * @param string $timeZone
     * @return UserBeanWithTemplate
     */
    public function setTimeZone($timeZone)
    {
        $this->timeZone = $timeZone;
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
     * @return UserBeanWithTemplate
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }


}