<?php
namespace CoreBundle\Doctrine\Subscriber;

use CoreBundle\Entity\Admin\Utilisateur;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\Common\Persistence\ManagerRegistry;
use CoreBundle\Entity\UtilisateurLogAction;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\UnitOfWork;

/**
 * Class UserActionLogSubscriber
 */
class UserActionLogSubscriber implements EventSubscriber
{
    /**
     * @var \Symfony\Component\DependencyInjection\Container
     */
    private $container;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var UnitOfWork
     */
    private $uow;

    /**
     * @var ManagerRegistry
     */
    private $managerRegistry;

    public function __construct(\Symfony\Component\DependencyInjection\ContainerInterface $container, ManagerRegistry $managerRegistry)
    {
        $this->container       = $container;
        $this->managerRegistry = $managerRegistry;
    }

    /**
     * @return array
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
     * @param $action
     * @param $entity
     */
    private function ifInstanceOfUtilisateurAndPersist($action, $entity)
    {
        if ($action == 'persist') {
            foreach ($entity as $key => $value) {
                if ($key != 'startDate') {
                    $this->setAndPersistUserActionLog($entity->getId(), $key, null, $value);
                }
            }
        }
    }

    /**
     * @param $key
     * @param $value
     * @param $utilisateurId
     */
    private function initUserActionLog($key, $value, $utilisateurId)
    {
        if ($key != 'startDate') {
            if ($value[0] != $value[1]) {
                $this->setAndPersistUserActionLog($utilisateurId, $key, $value[0], $value[1]);
            }
        }
    }

    /**
     * @param $action
     * @param $entity
     * @param UnitOfWork $uow
     */
    private function ifInstanceOfUtilisateurAndUpdate($action, $entity, UnitOfWork $uow)
    {
        if ($action == 'update') {
            $uow->computeChangeSets(); // do not compute changes if inside a listener
            foreach ($uow->getEntityChangeSet($entity) as $key => $value) {
                $this->initUserActionLog($key, $value, $entity->getId());
            }
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

            $this->ifInstanceOfUtilisateurAndUpdate('update', $entity, $this->uow);
            $this->ifInstanceOfUtilisateurAndPersist('persist', $entity);
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