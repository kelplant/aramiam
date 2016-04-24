<?php
namespace SalesforceApiBundle\Factory;

use CoreBundle\Factory\AbstractFactory;
use SalesforceApiBundle\Entity\ApiObjects\SalesforceUserTerritory;
use Doctrine\Common\Util\Inflector;

/**
 * Class SalesforceUserTerritoryFactory
 * @package SalesforceApiBundle\Factory
 */
class SalesforceUserTerritoryFactory extends AbstractFactory
{
    /**
     * @param $userTerritoryInfos
     * @return SalesforceUserTerritory
     */
    public function createFromEntity($userTerritoryInfos)
    {
        $newSalesforceUserTerritory = new SalesforceUserTerritory();
        foreach ($userTerritoryInfos as  $key => $value) {
            if ($value != "") {
                $newSalesforceUserTerritory->{"set" . Inflector::camelize($key)}($value);
            }
        }

        return $newSalesforceUserTerritory;
    }
}