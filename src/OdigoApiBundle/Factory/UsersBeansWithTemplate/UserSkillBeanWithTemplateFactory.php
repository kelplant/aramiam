<?php
namespace OdigoApiBundle\Factory\UserBeansWithTemplate;

use AppBundle\Factory\AbstractFactory;
use OdigoApiBundle\Entity\ApiObjects\UserBeansWithTemplate\UserSkillBeanWithTemplate;

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
        return new UserSkillBeanWithTemplate($UserSkillBeanWithTemplate['id'], $UserSkillBeanWithTemplate['level']);
    }
}