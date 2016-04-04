<?php
namespace CoreBundle\Services\Manager;

use Doctrine\ORM\EntityManager;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Class AbstractManager
 * @package CoreBundle\Services\Manager
 */
abstract class AbstractManager
{
    /**
     * @var EntityManager
     */
    protected $em;

    protected $entity;

    protected $entityName;

    protected $repository;

    protected $managerRegistry;

    /**
     * AbstractManager constructor.
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(ManagerRegistry $managerRegistry) {
        $this->managerRegistry = $managerRegistry;
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectManager|null
     */
    public function setUpEm() {
        return $this->managerRegistry->getManagerForClass($this->entity);
    }

    /**
     * @param $entity
     */
    public function save($entity) {
        $this->em = $this->setUpEm();
        $this->persistAndFlush($entity);
    }

    /**
     * @param $itemId
     * @return null|object
     */
    public function load($itemId) {
        $this->em = $this->setUpEm();
        return $this->getRepository()
            ->findOneBy(array('id' => $itemId));
    }

    /**
     * @param $itemId
     * @return bool|int
     */
    public function remove($itemId) {
        $this->em = $this->setUpEm();
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
        $this->em = $this->setUpEm();
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
        $this->em = $this->setUpEm();
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
        $this->em = $this->setUpEm();
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
    public function add($itemLoad) {
        $this->em = $this->setUpEm();
        $itemToSet = new $this->entity;
        try {
            $this->save($this->globalSetItem($itemToSet, $itemLoad));
            return 6669;
        } catch (\Exception $e) {
            return error_log($e->getMessage());
        }
    }

    /**
     * @return array
     */
    public function createList() {
        $this->em = $this->setUpEm();
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
    private function persistAndFlush($entity) {
        $this->em = $this->setUpEm();
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
        $this->em = $this->setUpEm();
        return $this->em->getRepository($this->entityName);
    }
}