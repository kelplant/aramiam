<?php
namespace OdigoApiBundle\Factory\Actions;

use AppBundle\Factory\AbstractFactory;
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
        return new CreateWithTemplateStruct($CreateWithTemplateStruct['wsLogin'], $CreateWithTemplateStruct['wsPassword'], $CreateWithTemplateStruct['userBean']);
    }
}