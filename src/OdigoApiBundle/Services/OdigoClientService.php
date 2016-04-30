<?php
namespace OdigoApiBundle\Services;

use OdigoApiBundle\Entity\ApiObjects\UserBeans\UserBean;
use OdigoApiBundle\Entity\ApiObjects\UserBeansWithTemplate\UserBeanWithTemplate;
use OdigoApiBundle\Factory\Actions\CreateAgentStructFactory;
use OdigoApiBundle\Factory\Actions\CreateWithTemplateStructFactory;
use OdigoApiBundle\Factory\Actions\DeleteUserStructFactory;
use OdigoApiBundle\Factory\Actions\ExportStructFactory;
use OdigoApiBundle\Factory\UserBeans\UserBeanFactory;
use OdigoApiBundle\Factory\UserBeansWithTemplate\UserBeanWithTemplateFactory;
use SoapFault;
use SoapClient;

class OdigoClientService implements OdigoClientServiceInterface
{
    /** @var UserBeanFactory $userBeanFactory */
    protected $userBeanFactory;

    /** @var UserBeanWithTemplateFactory $userBeanWithTemplateFactory */
    protected $userBeanWithTemplateFactory;

    /** @var CreateAgentStructFactory $createAgentFactory*/
    protected $createAgentStructFactory;

    /** @var CreateWithTemplateStructFactory $createWithTemplateStructFactory*/
    protected $createWithTemplateStructFactory;

    /** @var DeleteUserStructFactory $deleteUserFactory*/
    protected $deleteUserStructFactory;

    /** @var ExportStructFactory $exportStructFactory*/
    protected $exportStructFactory;

    /**
     * OdigoClientService constructor.
     * @param UserBeanFactory $userBeanFactory
     * @param UserBeanWithTemplateFactory $userBeanWithTemplateFactory
     * @param CreateAgentStructFactory $createAgentStructFactory
     * @param CreateWithTemplateStructFactory $createWithTemplateStructFactory
     * @param DeleteUserStructFactory $deleteUserStructFactory
     * @param ExportStructFactory $exportStructFactory
     */
    public function __construct(UserBeanFactory $userBeanFactory, UserBeanWithTemplateFactory $userBeanWithTemplateFactory, CreateAgentStructFactory $createAgentStructFactory, CreateWithTemplateStructFactory $createWithTemplateStructFactory, DeleteUserStructFactory $deleteUserStructFactory, ExportStructFactory $exportStructFactory)
    {
        $this->userBeanFactory = $userBeanFactory;
        $this->userBeanWithTemplateFactory = $userBeanWithTemplateFactory;
        $this->createAgentStructFactory = $createAgentStructFactory;
        $this->createWithTemplateStructFactory = $createWithTemplateStructFactory;
        $this->deleteUserStructFactory = $deleteUserStructFactory;
        $this->exportStructFactory = $exportStructFactory;
    }


    /**
     * @param $userBeanInfos
     * @return UserBean
     */
    private function generateUserBean($userBeanInfos)
    {
        return $this->userBeanFactory->createFromEntity($userBeanInfos);
    }

    /**
     * @param $parameters
     * @param $userBeanInfos
     * @return \Exception|\SoapFault
     */
    public function create($parameters, $userBeanInfos)
    {
        $client = new SoapClient($parameters['url'], array('classmap', array(
            'createAgent' => 'CreateAgentStruct',
            'CreateUserBean' => 'UserBean',
            'CreateUserSkillBean' => 'UserSkillBean',
        )));
        try {
            $response = $client->createAgent($this->createAgentStructFactory->createFromEntity(array('wsLogin' => $parameters['login'], 'wsPassword' => $parameters['password'], 'userBean' => $this->generateUserBean($userBeanInfos))));
        }
        catch (SoapFault $e) {
            $response = $e;
        }
        return $response;
    }

    /**
     * @param $userBeanWithTemplateInfos
     * @return UserBeanWithTemplate
     */
    private function generateUserBeanWithTemplate($userBeanWithTemplateInfos)
    {
        return $this->userBeanWithTemplateFactory->createFromEntity($userBeanWithTemplateInfos);
    }

    /**
     * @param $parameters
     * @param $userBeanWithTemplateInfos
     * @return \Exception|\SoapFault
     */
    public function createwithtemplate($parameters, $userBeanWithTemplateInfos)
    {
        $client = new SoapClient($parameters['url'], array('classmap', array(
            'createUserUsingTemplate' => 'CreateWithTemplateStruct',
            'UserBean' => 'UserBeanWithTemplate',
            'CreateUserSkillBean' => 'UserSkillBeanWithTemplate',
        )));
        try {
            $response = $client->createUserUsingTemplate($this->createWithTemplateStructFactory->createFromEntity(array('wsLogin' => $parameters['login'], 'wsPassword' => $parameters['password'], 'userBean' => $this->generateUserBeanWithTemplate($userBeanWithTemplateInfos))));
        }
        catch (SoapFault $e) {
            $response = $e;
        }
        return $response;
    }

    /**
     * @param $parameters
     * @param $userId
     * @return \Exception|\SoapFault
     */
    public function delete($parameters, $userId)
    {
        $client = new SoapClient($parameters['url'], array('classmap', array(
            'deleteUser' => 'DeleteUserStruct',
        )));
        try {
            $response = $client->deleteUser($this->deleteUserStructFactory->createFromEntity(array('wsLogin' => $parameters['login'], 'wsPassword' => $parameters['password'], 'userId' => $userId)));
        }
        catch (SoapFault $e) {
            $response = $e;
        }
        return $response;
    }

    /**
     * @param $parameters
     * @param $userId
     * @return \Exception|\SoapFault
     */
    public function export($parameters, $userId)
    {
        $client = new SoapClient($parameters['url'], array('classmap', array(
            'Export' => 'ExportStruct',
        )));
        try {
            $response = $client->export($this->exportStructFactory->createFromEntity(array('wsLogin' => $parameters['login'], 'wsPassword' => $parameters['password'], 'userId' => $userId)));
        }
        catch (SoapFault $e) {
            $response = $e;
        }
        return $response;
    }
}