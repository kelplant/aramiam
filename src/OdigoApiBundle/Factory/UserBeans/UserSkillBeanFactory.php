<?php
namespace OdigoApiBundle\Factory\UserBeans;

use AppBundle\Factory\AbstractFactory;
use OdigoApiBundle\Entity\ApiObjects\UserBeans\UserSkillBean;

/**
 * Class UserSkillBeanFactory
 * @package OdigoApiBundle\Factory\UserBeans
 */
class UserSkillBeanFactory extends AbstractFactory
{
    /**
     * @param $UserBeanSkillsInfos
     * @return UserSkillBean
     */
    public function createFromEntity($UserBeanSkillsInfos)
    {
        return new UserSkillBean($UserBeanSkillsInfos['level'], $UserBeanSkillsInfos['skillKeyword'], $UserBeanSkillsInfos['specialty']);
    }
}