<?php
namespace OdigoApiBundle\Factory\Actions;

use AppBundle\Factory\AbstractFactory;
use OdigoApiBundle\Entity\Actions\DeleteUserStruct;

/**
 * Class DeleteUserStructFactory
 * @package OdigoApiBundle\Factory\Actions
 */
class DeleteUserStructFactory extends AbstractFactory
{
    /**
     * @param $deleteUserStruct
     * @return DeleteUserStruct
     */
    public function createFromEntity($deleteUserStruct)
    {
        return new DeleteUserStruct($deleteUserStruct['wsLogin'], $deleteUserStruct['wsPassword'], $deleteUserStruct['userId']);
    }
}