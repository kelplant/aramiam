<?php
namespace OdigoApiBundle\Entity\Actions;

/**
 * Class FindUserStruct
 * @package OdigoApiBundle\Entity\Actions
 */
class FindUserStruct
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
     * The profile
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * - nillable : true
     * @var string
     */
    public $profile;
    /**
     * The userId
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * - nillable : true
     * @var string
     */
    public $userId;
    /**
     * The name
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * - nillable : true
     * @var string
     */
    public $name;
    /**
     * The irstName
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * - nillable : true
     * @var string
     */
    public $firstName;

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

    /**
     * @return string
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * @param string $profile
     * @return FindUserStruct
     */
    public function setProfile($profile)
    {
        $this->profile = $profile;
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
     * @return FindUserStruct
     */
    public function setName($name)
    {
        $this->name = $name;
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
     * @return FindUserStruct
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }
}