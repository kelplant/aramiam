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
     * @param LifecycleEventArgs $args
     * @param $action
     */
    private function ifInstanceOfUtilisateur(LifecycleEventArgs $args, $action)
    {
        $entityManager = $this->managerRegistry->getManagerForClass('CoreBundle\Entity\UtilisateurLogAction');

        $entity = $args->getObject();
        if ($entity instanceof Utilisateur) {
            $this->em = $this->managerRegistry->getManagerForClass('CoreBundle\Entity\Admin\Utilisateur');
            $this->uow = $this->em->getUnitOfWork();

            $this->ifInstanceOfUtilisateurAndUpdate('update', $entity, $this->uow, $entityManager);
            $this->ifInstanceOfUtilisateurAndPersist('persist', $entity, $entityManager);
        }
    }

    /**
     * @param $action
     * @param $entity
     * @param UnitOfWork $uow
     */
    private function ifInstanceOfUtilisateurAndUpdate($action, $entity, UnitOfWork $uow, $entityManager)
    {
        if ($action == 'update') {
            $uow->computeChangeSets(); // do not compute changes if inside a listener
            foreach ($uow->getEntityChangeSet($entity) as $key => $value) {
                $this->initUserActionLog($key, $value, $entity->getId(), $entityManager);
            }
        }
    }

    /**
     * @param $action
     * @param $entity
     */
    private function ifInstanceOfUtilisateurAndPersist($action, $entity, $entityManager)
    {
        if ($action == 'persist') {
            foreach ($entity as $key => $value) {
                if ($key != 'startDate') {
                    $date          = new \DateTime();
                    $userActionLog = new UtilisateurLogAction();

                    $userActionLog->setRequesterId($this->container->get('security.token_storage')->getToken()->getUser()->getId());
                    $userActionLog->setUtilisateurId($entity->getId());
                    $userActionLog->setField($key);
                    $userActionLog->setOldString(null);
                    $userActionLog->setNewString($value);
                    $userActionLog->setTimestamp($date);

                    $entityManager->persist($userActionLog);
                    $entityManager->flush();
                }
            }
        }
    }

    /**
     * @param $key
     * @param $value
     * @param $utilisateurId
     */
    private function initUserActionLog($key, $value, $utilisateurId, $entityManager)
    {
        if ($key != 'startDate') {
            if ($value[0] != $value[1]) {
                $date          = new \DateTime();
                $userActionLog = new UtilisateurLogAction();

                $userActionLog->setRequesterId($this->container->get('security.token_storage')->getToken()->getUser()->getId());
                $userActionLog->setUtilisateurId($utilisateurId);
                $userActionLog->setField($key);
                $userActionLog->setOldString($value[0]);
                $userActionLog->setNewString($value[1]);
                $userActionLog->setTimestamp($date);

                $entityManager->persist($userActionLog);
                $entityManager->flush();
            }
        }
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $this->ifInstanceOfUtilisateur($args, 'persist');
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->ifInstanceOfUtilisateur($args, 'update');
    }
}