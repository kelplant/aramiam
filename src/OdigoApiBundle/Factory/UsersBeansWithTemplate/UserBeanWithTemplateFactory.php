<?php
namespace OdigoApiBundle\Factory\UserBeansWithTemplate;

use AppBundle\Factory\AbstractFactory;
use OdigoApiBundle\Entity\UserBeansWithTemplate\UserBeanWithTemplate;

/**
 * Class UserBeanWithTemplateFactory
 * @package OdigoApiBundle\Factory\UserBeansWithTemplate
 */
class UserBeanWithTemplateFactory extends AbstractFactory
{
    /** @var UserSkillBeanWithTemplateFactory $userSkillBeanWithTemplateFactory */
    protected $userSkillBeanWithTemplateFactory;

    /**
     * UserBeanWithTemplate constructor.
     * @param UserSkillBeanWithTemplateFactory $userSkillBeanWithTemplateFactory
     */
    public function __construct(UserSkillBeanWithTemplateFactory $userSkillBeanWithTemplateFactory)
    {
        $this->userSkillBeanWithTemplateFactory = $userSkillBeanWithTemplateFactory;
    }

    /**
     * @param $userBeanWithTemplateInfos
     * @return UserBeanWithTemplate
     */
    public function createFromEntity($userBeanWithTemplateInfos)
    {
        return (new UserBeanWithTemplate(
            $userBeanWithTemplateInfos['active'], $userBeanWithTemplateInfos['data'], $userBeanWithTemplateInfos['ddiNumber'], $userBeanWithTemplateInfos['directAccessCode'],
            $userBeanWithTemplateInfos['firstName'], $userBeanWithTemplateInfos['language'], $userBeanWithTemplateInfos['listAgentGroup'],
            $this->userSkillBeanWithTemplateFactory->createFromEntity(array('id' => $userBeanWithTemplateInfos['skillId'], 'level' => $userBeanWithTemplateInfos['skillLevel'])),
            $userBeanWithTemplateInfos['listTemplate'], $userBeanWithTemplateInfos['mail'], $userBeanWithTemplateInfos['name'], $userBeanWithTemplateInfos['overloadGroup'], $userBeanWithTemplateInfos['overloadTemplate'],
            $userBeanWithTemplateInfos['password'], $userBeanWithTemplateInfos['phoneLoginNumber'], $userBeanWithTemplateInfos['phoneLoginPassword'], $userBeanWithTemplateInfos['templateId'],
            $userBeanWithTemplateInfos['timeZone'], $userBeanWithTemplateInfos['userId']));
    }
}
