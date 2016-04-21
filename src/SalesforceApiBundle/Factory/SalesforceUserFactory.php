<?php
namespace SalesforceApiBundle\Factory;

use CoreBundle\Factory\AbstractFactory;
use SalesforceApiBundle\Entity\SalesforceUser;
use Doctrine\Common\Util\Inflector;

/**
 * Class SalesforceUserFactory
 * @package CoreBundle\Factory\Applications\Salesforce
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