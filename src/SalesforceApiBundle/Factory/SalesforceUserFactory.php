<?php
namespace SalesforceApiBundle\Factory;

use CoreBundle\Factory\AbstractFactory;
use SalesforceApiBundle\Entity\ApiObjects\SalesforceUser;
use Doctrine\Common\Util\Inflector;

/**
 * Class SalesforceUserFactory
 * @package SalesforceApiBundle\Factory
 */
class SalesforceUserFactory extends AbstractFactory
{
    /**
     * @param $userInfos
     * @return SalesforceUser
     */
    public function createFromEntity($userInfos)
    {
        $newSalesforceUser = new SalesforceUser();
        foreach ($userInfos as  $key => $value) {
            if ($value != "") {
                $newSalesforceUser->{"set" . Inflector::camelize($key)}($value);
            }
        }

        return $newSalesforceUser;
    }
}