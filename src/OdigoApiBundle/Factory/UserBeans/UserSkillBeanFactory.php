<?php
namespace OdigoApiBundle\Factory\UserBeans;

use OdigoApiBundle\Factory\AbstractFactory;
use OdigoApiBundle\Entity\UserBeans\UserSkillBean;

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
        $UserSkillBean = new UserSkillBean(
            $UserBeanSkillsInfos['level'],
            $UserBeanSkillsInfos['skillKeyword'],
            $UserBeanSkillsInfos['specialty']
        );

        return $UserSkillBean;
    }
}