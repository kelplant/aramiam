<?php
namespace OdigoApiBundle\Entity\ApiObjects\Actions;

/**
 * Class DeleteUserStruct
 * @package OdigoApiBundle\Entity\ApiObjects\Actions
 */
class DeleteUserStruct
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
     * The userId
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * - nillable : true
     * @var string
     */
    public $userId;

    /**
     * DeleteUserStruct constructor.
     * @param string $wsLogin
     * @param string $wsPassword
     * @param string $userId
     */
    public function __construct($wsLogin, $wsPassword, $userId)
    {
        $this->wsLogin = $wsLogin;
        $this->wsPassword = $wsPassword;
        $this->userId = $userId;
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
     * @return DeleteUserStruct
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
     * @return DeleteUserStruct
     */
    public function setWsPassword($wsPassword)
    {
        $this->wsPassword = $wsPassword;
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
     * @return DeleteUserStruct
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }
}