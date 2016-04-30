<?php
namespace OdigoApiBundle\Factory\UserBeans;

use AppBundle\Factory\AbstractFactory;
use OdigoApiBundle\Entity\ApiObjects\UserBeans\UserBean;

class UserBeanFactory extends AbstractFactory
{
    /** @var UserSkillBeanFactory $userSkillBeanFactory */
    protected $userSkillBeanFactory;

    /**
     * UserBeanFactory constructor.
     * @param UserSkillBeanFactory $userSkillBeanFactory
     */
    public function __construct(UserSkillBeanFactory $userSkillBeanFactory)
    {
        $this->userSkillBeanFactory = $userSkillBeanFactory;
    }

    /**
     * @param $userBeanInfos
     * @return UserBean
     */
    public function createFromEntity($userBeanInfos)
    {
        return  (new UserBean(
            $userBeanInfos['activeState'], $userBeanInfos['agentGroups'], $userBeanInfos['breaks'], $userBeanInfos['calendarId'], $userBeanInfos['ddiNumber'], $userBeanInfos['disruptionDuration'],
            $userBeanInfos['email'], $userBeanInfos['enable2WaysSwitch'], $userBeanInfos['enableCallBack'], $userBeanInfos['enableConference'], $userBeanInfos['enableOutCall'],
            $userBeanInfos['enableRecording'], $userBeanInfos['firstName'], $userBeanInfos['languageId'], $userBeanInfos['loginTel'], $userBeanInfos['name'], $userBeanInfos['password'],
            $this->userSkillBeanFactory->createFromEntity(array('level' => $userBeanInfos['level'], 'skillKeyword' => $userBeanInfos['skillKeyword'], 'specialty' => $userBeanInfos['specialty'])),
            $userBeanInfos['transfertDDIAuthorized'], $userBeanInfos['userId'], $userBeanInfos['wrapupTime']));
    }
}
