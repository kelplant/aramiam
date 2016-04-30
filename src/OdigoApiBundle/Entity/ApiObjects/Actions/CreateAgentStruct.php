<?php
namespace OdigoApiBundle\Entity\ApiObjects\Actions;

use OdigoApiBundle\Entity\ApiObjects\UserBeans\UserBean;

/**
 * Class CreateAgentStruct
 * @package OdigoApiBundle\Entity\ApiObjects\Actions
 */
class CreateAgentStruct
{
    /**
     * - minOccurs : 0
     * - nillable : true
     * @var string
     */
    public $wsLogin;
    /**
     * - minOccurs : 0
     * - nillable : true
     * @var string
     */
    public $wsPassword;
    /**
     * - minOccurs : 0
     * - nillable : true
     * @var UserBean
     */
    public $userBean;

    /**
     * CreateAgentStruct constructor.
     * @param string $wsLogin
     * @param string $wsPassword
     * @param UserBean $userBean
     */
    public function __construct($wsLogin, $wsPassword, UserBean $userBean)
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
     * @return CreateAgentStruct
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
     * @return UserBean
     */
    public function getUserBean()
    {
        return $this->userBean;
    }

    /**
     * @param UserBean $userBean
     * @return CreateAgentStruct
     */
    public function setUserBean($userBean)
    {
        $this->userBean = $userBean;
        return $this;
    }
}