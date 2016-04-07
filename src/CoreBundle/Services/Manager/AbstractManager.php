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
            $itemToSet = $this->getRepository()->findOneById($itemId);
            $this->globalSetItem($itemToSet, $itemEditLoad);
            $this->em->flush();
            return 6667;
        } catch (\Exception $e) {
            return error_log($e->getMessage());
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
            return array('insert' => 6669, 'candidat' => $itemToSend);
        } catch (\Exception $e) {
            return error_log($e->getMessage());
        }
    }

    /**
     * @return array
     */
    public function createList()
    {
        $datas = $this->getRepository()->findAll();
        $finalDatas = [];
        foreach ($datas as $data) {
            $finalDatas[$data->getName()] = $data->getId();
        }
        return $finalDatas;
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
        $this->managerRegistry->getManagerForClass($this->entity);
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