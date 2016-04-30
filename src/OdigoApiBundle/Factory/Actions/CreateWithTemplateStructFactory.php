<?php
namespace OdigoApiBundle\Factory\Actions;

use OdigoApiBundle\Factory\AbstractFactory;
use OdigoApiBundle\Entity\Actions\CreateWithTemplateStruct;

/**
 * Class CreateWithTemplateStructFactory
 * @package OdigoApiBundle\Factory\Actions
 */
class CreateWithTemplateStructFactory extends AbstractFactory
{
    /**
     * @param $CreateWithTemplateStruct
     * @return CreateWithTemplateStruct
     */
    public function createFromEntity($CreateWithTemplateStruct)
    {
        $CreateWithTemplateStruct = new CreateWithTemplateStruct(
            $CreateWithTemplateStruct['wsLogin'],
            $CreateWithTemplateStruct['wsPassword'],
            $CreateWithTemplateStruct['userBean']
        );

        return $CreateWithTemplateStruct;
    }
}