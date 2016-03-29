<?php
namespace CoreBundle\Services\Manager;

use Doctrine\ORM\EntityManager;

abstract class AbstractManager
{
    /**
     * @var EntityManager
     */
    protected $em;

    protected $entity;

    protected $entityName;

    /**
     * BaseManager constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param $entity
     */
    public function save($entity)
    {
        $this->persistAndFlush($entity);
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
        return $this->em->getRepository($this->entityName);
    }

    /**
     * @param $itemId
     * @return null|object
     */
    public function load($itemId) {
        return $this->getRepository()
            ->findOneBy(array('id' => $itemId));
    }

    /**
     * @param $itemLoad
     * @return bool|int
     */
    public function add($itemLoad)
    {
        $itemToSet = new $this->entity;
        $itemToSet = $this->globalSetItem($itemToSet, $itemLoad);

        try {
            $this->save($itemToSet);
            return $message = 6669;
        } catch (\Exception $e) {
            return $message = error_log($e->getMessage());
        }
    }

    /**
     * @param $itemId
     * @return bool|int
     */
    public function remove($itemId)
    {
        $items = $this->getRepository()->findById($itemId);
        try {
            foreach ($items as $item) {
                $this->em->remove($item);
                $this->em->flush();
            }
            return $message = 6668;
        } catch (\Exception $e) {
            return $message = error_log($e->getMessage());
        }
    }

    /**
     * @param $itemId
     * @return bool|int
     */
    public function removeCandidat($itemId)
    {
        $itemToSet = $this->getRepository()->findOneById($itemId);
        try {
            $itemToSet->setIsArchived('1');
            $this->em->flush();
            return $message = 6668;
        } catch (\Exception $e) {
            return error_log($e->getMessage());
        }
    }
    /**
     * @param $itemId
     * @param $itemLoad
     * @return bool|string
     */
    public function edit($itemId, $itemLoad)
    {
        try
        {
            $itemToSet = $this->getRepository()->findOneById($itemId);
            $this->globalSetItem($itemToSet, $itemLoad);
            $this->em->flush();
            return $message = "6667";
        } catch (\Exception $e) {
            return $message = error_log($e->getMessage());
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
}