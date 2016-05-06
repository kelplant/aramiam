<?php
namespace CoreBundle\Doctrine\Subscriber;

use CoreBundle\Services\Manager\UtilisateurLogActionManager;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManager;
use CoreBundle\Entity\UtilisateurLogAction;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;

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
            /*'preUpdate',*/
        );
    }

    /**
     * @param PreUpdateEventArgs $args
     */
    public function preUpdate(PreUpdateEventArgs $args)
    {
        foreach ($args->getEntityChangeSet() as $key => $value) {
            $this->initUserActionLog($key, $value, $args->getEntity()->getId());
        }
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        $em = $this->managerRegistry->getManagerForClass('CoreBundle\Entity\Admin\Utilisateur');
        $uow = $em->getUnitOfWork();

        $uow->computeChangeSets(); // do not compute changes if inside a listener

        foreach ($uow->getEntityChangeSet($entity) as $key => $value) {
            $this->initUserActionLog($key, $value, $entity->getId());
        }
    }

    /**
     * @param $key
     * @param $value
     * @param $utilisateurId
     */
    private function initUserActionLog($key, $value, $utilisateurId)
    {
        $entityManager = $this->managerRegistry->getManagerForClass('CoreBundle\Entity\UtilisateurLogAction');

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
}