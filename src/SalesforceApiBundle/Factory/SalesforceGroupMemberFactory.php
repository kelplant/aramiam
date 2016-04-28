<?php
namespace SalesforceApiBundle\Factory;

use CoreBundle\Factory\AbstractFactory;
use SalesforceApiBundle\Entity\ApiObjects\SalesforceGroupMember;
use Doctrine\Common\Util\Inflector;

/**
 * Class SalesforceGroupMemberFactory
 * @package SalesforceApiBundle\Factory
 */
class SalesforceGroupMemberFactory extends AbstractFactory
{
    /**
     * @param $groupMemberInfos
     * @return SalesforceGroupMember
     */
    public function createFromEntity($groupMemberInfos)
    {
        $newSalesforceGroupMember = new SalesforceGroupMember();
        foreach ($groupMemberInfos as  $key => $value) {
            if ($value != "") {
                $newSalesforceGroupMember->{"set".Inflector::camelize($key)}($value);
            }
        }

        return $newSalesforceGroupMember;
    }
}