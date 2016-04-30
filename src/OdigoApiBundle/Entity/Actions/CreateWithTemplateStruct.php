<?php
namespace OdigoApiBundle\Entity\Actions;

use OdigoApiBundle\Entity\UserBeansWithTemplate\UserBeanWithTemplate;

/**
 * Class CreateWithTemplateStruct
 * @package OdigoApiBundle\Entity\Actions
 */
class CreateWithTemplateStruct
{
    /**
     * The wsLogin
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * - nillable : true
     * @var string
     */
    public $wsLogin;
    /**
     * The wsPassword
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * - nillable : true
     * @var string
     */
    public $wsPassword;
    /**
     * The userBean
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * - nillable : true
     * @var UserBeanWithTemplate
     */
    public $userBean;

    /**
     * CreateAgentStruct constructor.
     * @param string $wsLogin
     * @param string $wsPassword
     * @param UserBeanWithTemplate $userBean
     */
    public function __construct($wsLogin, $wsPassword, UserBeanWithTemplate $userBean)
    {
        $this->wsLogin = $wsLogin;
        $this->wsPassword = $wsPassword;
        $this->userBean = $userBean;
    }

    /**
     * @return string
     */
    public function getWsLogin()
    {
        return $this->wsLogin;
    }

    /**
     * @param string $wsLogin
     * @return CreateWithTemplateStruct
     */
    public function setWsLogin($wsLogin)
    {
        $this->wsLogin = $wsLogin;
        return $this;
    }

    /**
     * @return string
     */
    public function getWsPassword()
    {
        return $this->wsPassword;
    }

    /**
     * @param string $wsPassword
     * @return CreateAgentStruct
     */
    public function setWsPassword($wsPassword)
    {
        $this->wsPassword = $wsPassword;
        return $this;
    }

    /**
     * @return UserBeanWithTemplate
     */
    public function getUserBean()
    {
        return $this->userBean;
    }

    /**
     * @param UserBeanWithTemplate $userBean
     * @return CreateAgentStruct
     */
    public function setUserBean($userBean)
    {
        $this->userBean = $userBean;
        return $this;
    }
}