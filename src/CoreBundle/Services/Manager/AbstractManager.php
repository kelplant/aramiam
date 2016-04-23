<?php
namespace CoreBundle\Services\Manager;

use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Class AbstractManager
 * @package CoreBundle\Services\Manager
 */
abstract class AbstractManager
{

    protected $em;

    protected $entity;

    protected $entityName;

    protected $repository;
    /**
     * @var ManagerRegistry
     */
    protected $managerRegistry;

    /**
     * AbstractManager constructor.
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(ManagerRegistry $managerRegistry) {
        $this->managerRegistry = $managerRegistry;
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
     * @return bool|int
     */
    public function remove($itemId) {
        $items = $this->getRepository()->findById($itemId);
        try {
            foreach ($items as $item) {
                $this->em->remove($item);
                $this->em->flush();
            }
            return 6668;
        } catch (\Exception $e) {
            return error_log($e->getMessage());
        }
    }

    /**
     * @param $itemId
     * @return bool|int
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
            return 6668;
        } catch (\Exception $e) {
            return error_log($e->getMessage());
        }
    }

    /**
     * @param $itemId
     * @return bool|int
     */
    public function retablir($itemId) {
        $itemToSet = $this->getRepository()->findOneById($itemId);
        try {
            $itemToSet->setIsArchived('0');
            $this->em->flush();
            return 6668;
        } catch (\Exception $e) {
            return error_log($e->getMessage());
        }
    }

    /**
     * @param $itemId
     * @param $itemEditLoad
     * @return bool|int
     */
    public function edit($itemId, $itemEditLoad) {
        try {
            $this->globalSetItem($this->getRepository()->findOneById($itemId), $itemEditLoad);
            $this->em->flush();
            return array('errorCode' => 6667, 'item' => $itemId);
        } catch (\Exception $e) {
            return array('errorCode' => error_log($e->getMessage()), 'error' => $e->getMessage(), 'item' => $itemId);
        }
    }

    /**
     * @param $itemLoad
     * @return bool|int
     */
    public function add($itemLoad)
    {
        $itemToSet = $itemToSend = new $this->entity;
        try {
            $this->save($this->globalSetItem($itemToSet, $itemLoad));
            return array('errorCode' => 6669, 'item' => $itemToSend);
        } catch (\Exception $e) {
            return array('errorCode' => error_log($e->getMessage()), 'error' => $e->getMessage(), 'item' => null);
        }
    }

    /**
     * @param $nameInOdigo
     * @return mixed
     */
    public function returnIdFromOdigoName($nameInOdigo)
    {
        return $this->getRepository()->findOneByNameInOdigo($nameInOdigo)->getId();
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
     * @return mixed
     */
    public function truncateTable()
    {
        $connection = $this->managerRegistry->getConnection();
        try {
            return $connection->executeUpdate($connection->getDatabasePlatform()->getTruncateTableSQL($this->managerRegistry->getManager()->getClassMetadata($this->entityName)->getTableName(), true));
        } catch (\Exception $e) {
            return $e->getMessage();
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
     * @return mixed
     */
    public function getEntity()
    {
        return $this->entity;
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
     * @return mixed
     */
    public function getEntityName()
    {
        return $this->entityName;
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
}