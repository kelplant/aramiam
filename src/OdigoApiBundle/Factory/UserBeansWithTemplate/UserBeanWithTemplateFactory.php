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
            $active = $userBeanWithTemplateInfos['active'],
            $data = $userBeanWithTemplateInfos['data'],
            $ddiNumber = $userBeanWithTemplateInfos['ddiNumber'],
            $directAccessCode = $userBeanWithTemplateInfos['directAccessCode'],
            $firstName = $userBeanWithTemplateInfos['firstName'],
            $language = $userBeanWithTemplateInfos['language'],
            $listAgentGroup = $userBeanWithTemplateInfos['listAgentGroup'],
            $listSkill = $this->userSkillBeanWithTemplateFactory->createFromEntity(array(
                'id' => $userBeanWithTemplateInfos['skillId'],
                'level' => $userBeanWithTemplateInfos['skillLevel'],
            )),
            $listTemplate = $userBeanWithTemplateInfos['listTemplate'],
            $mail = $userBeanWithTemplateInfos['mail'],
            $name = $userBeanWithTemplateInfos['name'],
            $overloadGroup = $userBeanWithTemplateInfos['overloadGroup'],
            $overloadTemplate = $userBeanWithTemplateInfos['overloadTemplate'],
            $password = $userBeanWithTemplateInfos['password'],
            $phoneLoginNumber = $userBeanWithTemplateInfos['phoneLoginNumber'],
            $phoneLoginPassword = $userBeanWithTemplateInfos['phoneLoginPassword'],
            $templateId = $userBeanWithTemplateInfos['templateId'],
            $timeZone = $userBeanWithTemplateInfos['timeZone'],
            $userId = $userBeanWithTemplateInfos['userId']
        ));
    }
}
