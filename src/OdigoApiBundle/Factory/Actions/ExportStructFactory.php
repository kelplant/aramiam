<?php
namespace OdigoApiBundle\Factory\Actions;

use AppBundle\Factory\AbstractFactory;
use OdigoApiBundle\Entity\Actions\ExportStruct;

/**
 * Class ExportStructFactory
 * @package OdigoApiBundle\Factory\Actions
 */
class ExportStructFactory extends AbstractFactory
{
    /**
     * @param $exportStruct
     * @return ExportStruct
     */
    public function createFromEntity($exportStruct)
    {
        return new ExportStruct($exportStruct['wsLogin'], $exportStruct['wsPassword'], $exportStruct['userId']);
    }
}