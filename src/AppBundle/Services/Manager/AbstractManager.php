<?php
namespace AppBundle\Services\Manager;

use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\Common\Util\Inflector;

/**
 * Class AbstractManager
 * @package AppBundle\Services\Manager
 */
abstract class AbstractManager
{
    protected $em;

    protected $entity;

    protected $entityName;

    protected $argname;

    protected $repository;

    protected $session;

    /**
     * @var ManagerRegistry
     */
    protected $managerRegistry;

    /**
     * AbstractManager constructor.
     * @param ManagerRegistry $managerRegistry
     * @param Session $session
     */
    public function __construct(ManagerRegistry $managerRegistry, Session $session) {
        $this->managerRegistry = $managerRegistry;
        $this->session = $session;
    }

    /**
     * @param $message
     */
    public function appendSessionMessaging($message)
    {
        $actualMessage = $this->session->get('messaging');
        $actualMessage[] = $message;
        $this->session->set('messaging', $actualMessage);
    }

    /**
     * @param $entity
     */
    public function save($entity) {
        $this->persistAndFlush($entity);
    }

    /**
     *
     */
    public function flush() {
        $this->em->flush();
    }

    /**
     * @param $itemId
     * @return object
     */
    public function load($itemId) {
        return $this->getRepository()
            ->findOneBy(array('id' => $itemId));
    }

    /**
     * @param $itemId
     * @return array
     */
    public function remove($itemId) {
        $items = $this->getRepository()->findById($itemId);
        try {
            foreach ($items as $item) {
                $this->em->remove($item);
                $this->em->flush();
            }
            $this->appendSessionMessaging(array('errorCode' => 0, 'message' => $this->argname.' a eté correctionement Suprrimé(e)'));
        } catch (\Exception $e) {
            $this->appendSessionMessaging(array('errorCode' => error_log($e->getMessage()), 'message' => $e->getMessage()));
        }
        return array('item' => $itemId);
    }

    /**
     * @param $itemId
     * @param $isArchived
     * @return array
     */
    public function removeCandidat($itemId, $isArchived) {
        $itemToSet = $this->getRepository()->findOneById($itemId);
        try {
            if ($isArchived == '0') {
                $itemToSet->setIsArchived('1');
            } elseif ($isArchived == '1') {
                $itemToSet->setIsArchived('0');
            }
            $this->em->flush();
            $this->appendSessionMessaging(array('errorCode' => 0, 'message' => $this->argname.' a eté correctionement Archivé(e)'));
        } catch (\Exception $e) {
            $this->appendSessionMessaging(array('errorCode' => error_log($e->getMessage()), 'message' => $e->getMessage()));
        }
        return array('item' => $itemId);
    }

    /**
     * @param $archivedItemId
     * @return array
     */
    public function retablir($archivedItemId) {
        $itemToSet = $this->getRepository()->findOneById($archivedItemId);
        try {
            $itemToSet->setIsArchived('0');
            $this->em->flush();
            $this->appendSessionMessaging(array('errorCode' => 0, 'message' => $this->argname.' a eté correctionement Rétabli(e)'));
        } catch (\Exception $e) {
            $this->appendSessionMessaging(array('errorCode' => error_log($e->getMessage()), 'message' => $e->getMessage()));
        }
        return array('item' => $archivedItemId);
    }

    /**
     * @param $itemToSet
     * @param $itemLoad
     * @return object
     */
    public function globalSetItem($itemToSet, $itemLoad)
    {
        foreach ($itemLoad as  $key => $value) {
            if (Inflector::camelize($key) != "token")
            {
                $itemToSet->{"set".Inflector::camelize($key)}($value);
            }
        }
        return $itemToSet;
    }

    /**
     * @param $itemToEditId
     * @param $ContentToAddToEditedItem
     * @return array
     */
    public function edit($itemToEditId, $ContentToAddToEditedItem) {
        try {
            $this->globalSetItem($this->getRepository()->findOneById($itemToEditId), $ContentToAddToEditedItem);
            $this->em->flush();
            $this->appendSessionMessaging(array('errorCode' => 0, 'message' => $this->argname.' a eté correctionement Mis(e) à jour'));
        } catch (\Exception $e) {
            $this->appendSessionMessaging(array('errorCode' => error_log($e->getMessage()), 'message' => $e->getMessage()));
        }
        return array('item' => $itemToEditId);
    }

    /**
     * @param $itemLoad
     * @return array
     */
    public function add($itemLoad)
    {
        $itemToSet = $itemToSend = new $this->entity;
        try {
            $this->save($this->globalSetItem($itemToSet, $itemLoad));
            $this->appendSessionMessaging(array('errorCode' => 0, 'message' => $this->argname.' a eté correctionement Créé(e)'));
        } catch (\Exception $e) {
            $this->appendSessionMessaging(array('errorCode' => error_log($e->getMessage()), 'message' => $e->getMessage()));
        }
        return array('item' => $itemToSend);
    }

    /**
     * @return array
     */
    public function createList()
    {
        $datas = $this->getRepository()->findAll();
        $finalDatas = [];
        foreach ($datas as $data) {
            if ($this->entity == 'CoreBundle\Entity\Admin\Utilisateur') {
                $finalDatas[$data->getViewName()] = $data->getId();
            } else {
                $finalDatas[$data->getName()] = $data->getId();
            }
        }
        return $finalDatas;
    }

    /**
     *
     */
    public function truncateTable()
    {
        $connection = $this->managerRegistry->getConnection();
        try {
            $this->appendSessionMessaging(array('errorCode' => 0, 'message' => $this->argname.' a eté correctionement Vidée'));
            $connection->executeUpdate($connection->getDatabasePlatform()->getTruncateTableSQL($this->managerRegistry->getManager()->getClassMetadata($this->entityName)->getTableName(), true));
        } catch (\Exception $e) {
            $this->appendSessionMessaging(array('errorCode' => error_log($e->getMessage()), 'message' => $e->getMessage()));
        }
    }

    /**
     * @param $entity
     */
    private function persistAndFlush($entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
    }

    /**
     * @param mixed $entity
     * @return AbstractManager
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
        $this->em = $this->managerRegistry->getManagerForClass($this->entity);
        return $this;
    }

    /**
     * @param $repository
     * @return AbstractManager
     */
    public function setRepository($repository)
    {
        $this->repository = $repository;
        return $this;
    }

    /**
     * @param mixed $entityName
     * @return AbstractManager
     */
    public function setEntityName($entityName)
    {
        $this->entityName = $entityName;
        return $this;
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getRepository()
    {
        return $this->managerRegistry->getManager()->getRepository($this->entityName);
    }

    /**
     * @param mixed $em
     * @return AbstractManager
     */
    public function setEm($em)
    {
        $this->em = $em;
        return $this;
    }

    /**
     * @param mixed $argname
     * @return AbstractManager
     */
    public function setArgname($argname)
    {
        $this->argname = $argname;
        return $this;
    }

    /**
     * @param ManagerRegistry $managerRegistry
     * @return AbstractManager
     */
    public function setManagerRegistry($managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
        return $this;
    }
}