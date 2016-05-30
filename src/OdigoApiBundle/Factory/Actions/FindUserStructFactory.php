<?php
namespace OdigoApiBundle\Factory\Actions;

use AppBundle\Factory\AbstractFactory;
use OdigoApiBundle\Entity\Actions\FindUserStruct;

/**
 * Class FindUserStructFactory
 * @package OdigoApiBundle\Factory\Actions
 */
class FindUserStructFactory extends AbstractFactory
{
    /**
     * @param $findUserStruct
     * @return FindUserStruct
     */
    public function createFromEntity($findUserStruct)
    {
        $userToLook = new FindUserStruct($findUserStruct);
        $userToLook->setWsLogin($findUserStruct['wsLogin']);
        $userToLook->setWsPassword($findUserStruct['wsPassword']);
        $userToLook->setProfile($findUserStruct['profile']);
        $userToLook->setUserId($findUserStruct['userId']);
    }
}