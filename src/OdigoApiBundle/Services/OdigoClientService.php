<?php
namespace OdigoApiBundle\Services;

use CoreBundle\Services\Manager\Admin\UtilisateurManager;
use OdigoApiBundle\Entity\UserBeans\UserBean;
use OdigoApiBundle\Entity\UserBeansWithTemplate\UserBeanWithTemplate;
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

    /** @var UtilisateurManager $utilisateurManager*/
    protected $utilisateurManager;

    /**
     * OdigoClientService constructor.
     * @param UserBeanFactory $userBeanFactory
     * @param UserBeanWithTemplateFactory $userBeanWithTemplateFactory
     * @param CreateAgentStructFactory $createAgentStructFactory
     * @param CreateWithTemplateStructFactory $createWithTemplateStructFactory
     * @param DeleteUserStructFactory $deleteUserStructFactory
     * @param ExportStructFactory $exportStructFactory
     * @param UtilisateurManager $utilisateurManager
     */
    public function __construct(UserBeanFactory $userBeanFactory, UserBeanWithTemplateFactory $userBeanWithTemplateFactory, CreateAgentStructFactory $createAgentStructFactory, CreateWithTemplateStructFactory $createWithTemplateStructFactory, DeleteUserStructFactory $deleteUserStructFactory, ExportStructFactory $exportStructFactory, UtilisateurManager $utilisateurManager)
    {
        $this->userBeanFactory                 = $userBeanFactory;
        $this->userBeanWithTemplateFactory     = $userBeanWithTemplateFactory;
        $this->createAgentStructFactory        = $createAgentStructFactory;
        $this->createWithTemplateStructFactory = $createWithTemplateStructFactory;
        $this->deleteUserStructFactory         = $deleteUserStructFactory;
        $this->exportStructFactory             = $exportStructFactory;
        $this->utilisateurManager              = $utilisateurManager;
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
     * @param $userBeanWithTemplateInfos
     * @return UserBeanWithTemplate
     */
    private function generateUserBeanWithTemplate($userBeanWithTemplateInfos)
    {
        return $this->userBeanWithTemplateFactory->createFromEntity($userBeanWithTemplateInfos);
    }

    /**
     * @param $parameters
     * @param $userBeanInfos
     * @return \Exception|\SoapFault
     */
    public function create($parameters, $userBeanInfos)
    {
        $client = new SoapClient($parameters['url'], array('classmap', array('createAgent' => 'CreateAgentStruct', 'CreateUserBean' => 'UserBean', 'CreateUserSkillBean' => 'UserSkillBean')));
        try {
            $client->createAgent($this->createAgentStructFactory->createFromEntity(array('wsLogin' => $parameters['login'], 'wsPassword' => $parameters['password'], 'userBean' => $this->generateUserBean($userBeanInfos))));
            $this->utilisateurManager->appendSessionMessaging(array('errorCode' => '0', 'message' => 'Utilisateur créé correctement dans Odigo'));
        } catch (SoapFault $e) {
            $this->utilisateurManager->appendSessionMessaging(array('errorCode' => error_log($e->getMessage()), 'message' => $e->getMessage()));
        }
    }

    /**
     * @param $parameters
     * @param $userBeanWithTemplateInfos
     * @return \Exception|\SoapFault
     */
    public function createwithtemplate($parameters, $userBeanWithTemplateInfos)
    {
        $client = new SoapClient($parameters['url'], array('classmap', array('createUserUsingTemplate' => 'CreateWithTemplateStruct', 'UserBean' => 'UserBeanWithTemplate', 'CreateUserSkillBean' => 'UserSkillBeanWithTemplate')));
        try {
            $client->createUserUsingTemplate($this->createWithTemplateStructFactory->createFromEntity(array('wsLogin' => $parameters['login'], 'wsPassword' => $parameters['password'], 'userBean' => $this->generateUserBeanWithTemplate($userBeanWithTemplateInfos))));
            $this->utilisateurManager->appendSessionMessaging(array('errorCode' => '0', 'message' => 'Utilisateur créé correctement dans Odigo'));
        } catch (SoapFault $e) {
            $this->utilisateurManager->appendSessionMessaging(array('errorCode' => error_log($e->getMessage()), 'message' => $e->getMessage()));
        }
    }

    /**
     * @param $parameters
     * @param $userId
     * @return \Exception|\SoapFault
     */
    public function delete($parameters, $userId)
    {
        $client = new SoapClient($parameters['url'], array('classmap', array('deleteUser' => 'DeleteUserStruct')));
        try {
            $client->deleteUser($this->deleteUserStructFactory->createFromEntity(array('wsLogin' => $parameters['login'], 'wsPassword' => $parameters['password'], 'userId' => $userId)));
            $this->utilisateurManager->appendSessionMessaging(array('errorCode' => '0', 'message' => 'Utilisateur '.$userId.' supprimé correctement dans Odigo'));
        } catch (SoapFault $e) {
            $this->utilisateurManager->appendSessionMessaging(array('errorCode' => error_log($e->getMessage()), 'message' => $e->getMessage()));
        }
    }

    /**
     * @param $parameters
     * @param $userId
     * @return \Exception|\SoapFault
     */
    public function export($parameters, $userId)
    {
        $client = new SoapClient($parameters['url'], array('classmap', array('Export' => 'ExportStruct')));
        try {
            $client->export($this->exportStructFactory->createFromEntity(array('wsLogin' => $parameters['login'], 'wsPassword' => $parameters['password'], 'userId' => $userId)));
            $this->utilisateurManager->appendSessionMessaging(array('errorCode' => '0', 'message' => 'Export Odigo Ok'));
        } catch (SoapFault $e) {
            $this->utilisateurManager->appendSessionMessaging(array('errorCode' => error_log($e->getMessage()), 'message' => $e->getMessage()));
        }
    }
}