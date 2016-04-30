<?php
namespace OdigoApiBundle\Factory;

/**
 * Class AbstractFactory
 * @package OdigoApiBundle\Factory
 */
abstract class AbstractFactory
{
    /**
     * @param $entityData
     * @return mixed
     */
    abstract public function createFromEntity($entityData);

    /**
     * @param array $collection
     * @return array
     */
    public function createFromCollection(array $collection)
    {
        $result = [];
        foreach($collection as $entityData) {
            $result[] = $this->createFromEntity($entityData);
        }
        return $result;
    }
}