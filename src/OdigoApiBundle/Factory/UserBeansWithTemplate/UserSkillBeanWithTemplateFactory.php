<?php
namespace OdigoApiBundle\Factory\UserBeansWithTemplate;

use OdigoApiBundle\Factory\AbstractFactory;
use OdigoApiBundle\Entity\UserBeansWithTemplate\UserSkillBeanWithTemplate;

/**
 * Class UserSkillBeanWithTemplateFactory
 * @package OdigoApiBundle\Factory\UserBeansWithTemplate
 */
class UserSkillBeanWithTemplateFactory extends AbstractFactory
{
    /**
     * @param $UserSkillBeanWithTemplate
     * @return UserSkillBeanWithTemplate
     */
    public function createFromEntity($UserSkillBeanWithTemplate)
    {
        return new UserSkillBeanWithTemplate(
            $UserSkillBeanWithTemplate['id'],
            $UserSkillBeanWithTemplate['level']
        );
    }
}