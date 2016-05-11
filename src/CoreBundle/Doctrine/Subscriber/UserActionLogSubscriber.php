<?php
namespace CoreBundle\Doctrine\Subscriber;

use CoreBundle\Entity\Admin\Utilisateur;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\Common\Persistence\ManagerRegistry;
use CoreBundle\Entity\UtilisateurLogAction;
use Doctrine\ORM\UnitOfWork;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class UserActionLogSubscriber
 */
class UserActionLogSubscriber implements EventSubscriber
{
    /**
     * @var \Symfony\Component\DependencyInjection\Container
     */
    private $container;

    private $em;

    /**
     * @var UnitOfWork
     */
    private $uow;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var ManagerRegistry
     */
    private $managerRegistry;

    /**
     * @var boolean
     */
    private $updateActiveDirectory;

    /**
     * @var boolean
     */
    private $updateGmailLink;

    /**
     * @var boolean
     */
    private $updateSalesforceLink;

    /**
     * UserActionLogSubscriber constructor.
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     * @param ManagerRegistry $managerRegistry
     * @param RequestStack $requestStack
     */
    public function __construct(\Symfony\Component\DependencyInjection\ContainerInterface $container, ManagerRegistry $managerRegistry, RequestStack $requestStack)
    {
        $this->container                 = $container;
        $this->managerRegistry           = $managerRegistry;
        $this->requestStack              = $requestStack;
    }

    /**
     * @return string[]
     */
    public function getSubscribedEvents()
    {
        return array(
            'postUpdate',
            'postPersist',
        );
    }

    /**
     * @param $utilisateurId
     * @param $key
     * @param $oldValue
     * @param $newValue
     */
    private function setAndPersistUserActionLog($utilisateurId, $key, $oldValue, $newValue)
    {
        $date          = new \DateTime();
        $userActionLog = new UtilisateurLogAction();

        $userActionLog->setRequesterId($this->container->get('security.token_storage')->getToken()->getUser()->getId());
        $userActionLog->setUtilisateurId($utilisateurId);
        $userActionLog->setField($key);
        $userActionLog->setOldString($oldValue);
        $userActionLog->setNewString($newValue);
        $userActionLog->setTimestamp($date);

        $this->em->persist($userActionLog);
        $this->em->flush();
    }

    /**
     * @param string $action
     * @param Utilisateur $entity
     */
    private function ifInstanceOfUtilisateurAndPersist($action, $entity)
    {
        if ($action == 'persist') {
            foreach ($entity as $key => $value) {
                if ($key != 'startDate' && $key != 'createdAt') {
                    $this->setAndPersistUserActionLog($entity->getId(), $key, null, $value);
                }
            }
        }
    }

    /**
     * @param $key
     * @param $value
     * @param integer $utilisateurId
     */
    private function initUserActionLog($key, $value, $utilisateurId)
    {
        if ($key != 'startDate' && $key != 'updatedAt') {
            $basicUpdateCases = array('surname', 'viewName', 'name', 'email', 'service', 'fonction');
            if ($value[0] != $value[1] && $value[0] != null) {
                if (array_search($key, $basicUpdateCases) !== false) {
                    $this->updateActiveDirectory = true;
                    $this->updateGmailLink = true;
                    $this->updateSalesforceLink = true;
                }
                $this->setAndPersistUserActionLog($utilisateurId, $key, $value[0], $value[1]);
            }
        }
    }

    /**
     * @param $tabToSend
     */
    private function ifUserAsGmailAccountLink($tabToSend)
    {
        if ($this->requestStack->getCurrentRequest()->request->get('utilisateur')["isCreateInGmail"] != null && $this->requestStack->getCurrentRequest()->request->get('utilisateur')["isCreateInGmail"] != '0') {
            $this->container->get('google.google_user_api_service')->modifyInfosForUser($tabToSend, $this->container->getParameter('google_api'));
        }
    }

    /**
     * @param $tabToSend
     */
    private function ifUserAsActiveDirectoryAccount($tabToSend)
    {
        if ($this->requestStack->getCurrentRequest()->request->get('utilisateur')["isCreateInWindows"] != null && $this->requestStack->getCurrentRequest()->request->get('utilisateur')["isCreateInWindows"] != '0') {
            $this->container->get('ad.active_directory_api_user_service')->modifyInfosForUser($tabToSend, $this->container->getParameter('active_directory'));
        }
    }

    /**
     * @param $tabToSend
     */
    private function ifUserAsSalesforceAccount($tabToSend)
    {
        if ($this->requestStack->getCurrentRequest()->request->get('utilisateur')["isCreateInSalesforce"] != null) {
            $this->container->get('salesforce.salesforce_api_user_service')->ifUserUpdated($tabToSend, $this->container->getParameter('salesforce'));
        }
    }

    /**
     * @param $tabToSend
     */
    private function executeConditionalEditForPropagation($tabToSend)
    {
        if ($this->updateGmailLink === true) {
            $this->ifUserAsGmailAccountLink($tabToSend);
        }
        if ($this->updateActiveDirectory === true) {
            $this->ifUserAsActiveDirectoryAccount($tabToSend);
        }
        if ($this->updateSalesforceLink === true) {
            $this->ifUserAsSalesforceAccount($tabToSend);
        }
    }

    /**
     * @param string $action
     * @param Utilisateur $entity
     * @param UnitOfWork $uow
     */
    private function ifInstanceOfUtilisateurAndUpdate($action, $entity, UnitOfWork $uow)
    {
        if ($action == 'update') {
            $uow->computeChangeSets(); // do not compute changes if inside a listener
            $changeSet = $uow->getEntityChangeSet($entity);
            if (isset($changeSet['email'][0]) === true) {
                $oldEmail = $changeSet['email'][0];
            } else {
                $oldEmail = $this->requestStack->getCurrentRequest()->request->get('utilisateur')['email'];
            }
            $tabToSend = array('utilisateurId' => $this->requestStack->getCurrentRequest()->request->get('utilisateur')['id'], 'newDatas' => array('givenName' => $this->requestStack->getCurrentRequest()->request->get('utilisateur')['surname'], 'displayName' => $this->requestStack->getCurrentRequest()->request->get('utilisateur')['viewName'], 'sn' => $this->requestStack->getCurrentRequest()->request->get('utilisateur')['name'], 'mail' => $this->requestStack->getCurrentRequest()->request->get('utilisateur')['email']), 'utilisateurService' => $this->requestStack->getCurrentRequest()->request->get('utilisateur')['service'], 'utilisateurFonction' => $this->requestStack->getCurrentRequest()->request->get('utilisateur')['fonction'], 'utilisateurOldService' => $changeSet['service'][0], 'utilisateurOldFonction' => $changeSet['fonction'][0], 'utilisateurOldEmail' => $oldEmail, 'request' => $this->requestStack->getCurrentRequest());
            foreach ($changeSet as $key => $value) {
                $this->initUserActionLog($key, $value, $entity->getId());
            }
            $this->executeConditionalEditForPropagation($tabToSend);
        }
    }

    /**
     * @param LifecycleEventArgs $args
     */
    private function ifInstanceOfUtilisateur(LifecycleEventArgs $args)
    {
        $this->em = $this->managerRegistry->getManagerForClass('CoreBundle\Entity\Admin\Utilisateur');

        $entity = $args->getObject();
        if ($entity instanceof Utilisateur) {
            $this->uow = $this->em->getUnitOfWork();
            $submitToIgnore = array('Créer Session Windows', 'Créer sur Gmail', 'Créer sur Salesforce');
            if (array_search($this->requestStack->getCurrentRequest()->request->get('sendaction'), $submitToIgnore) === false) {
                $this->ifInstanceOfUtilisateurAndUpdate('update', $entity, $this->uow);
                $this->ifInstanceOfUtilisateurAndPersist('persist', $entity);
            }
        }
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $this->ifInstanceOfUtilisateur($args);
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->ifInstanceOfUtilisateur($args);
    }
}