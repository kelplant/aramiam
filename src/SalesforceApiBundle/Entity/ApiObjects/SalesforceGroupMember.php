<?php
namespace SalesforceApiBundle\Entity\ApiObjects;

/**
 * Class SalesforceGroupMember
 * @package SalesforceApiBundle\Entity\ApiObjects
 */
class SalesforceGroupMember
{
    /**
     *
     * @var string
     */
    public $GroupId;

    /**
     * @var string
     */
    public $UserOrGroupId;

    /**
     * @return string
     */
    public function getGroupId()
    {
        return $this->GroupId;
    }

    /**
     * @param string $GroupId
     * @return SalesforceGroupMember
     */
    public function setGroupId($GroupId)
    {
        $this->GroupId = $GroupId;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserOrGroupId()
    {
        return $this->UserOrGroupId;
    }

    /**
     * @param string $UserOrGroupId
     * @return SalesforceGroupMember
     */
    public function setUserOrGroupId($UserOrGroupId)
    {
        $this->UserOrGroupId = $UserOrGroupId;
        return $this;
    }
}