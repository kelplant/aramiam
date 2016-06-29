<?php
namespace OdigoApiBundle\Factory\Actions;

use AppBundle\Factory\AbstractFactory;
use OdigoApiBundle\Entity\Actions\CreateAgentStruct;

/**
 * Class CreateAgentStructFactory
 * @package OdigoApiBundle\Factory\Actions
 */
class CreateAgentStructFactory extends AbstractFactory
{
    /**
     * @param $createAgentStruct
     * @return CreateAgentStruct
     */
    public function createFromEntity($createAgentStruct)
    {
        return new CreateAgentStruct(
            $createAgentStruct['wsLogin'],
            $createAgentStruct['wsPassword'],
            $createAgentStruct['userBean']
        );
    }
}