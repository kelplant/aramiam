<?php
namespace CoreBundle\Services\Manager;

use AppBundle\Services\Manager\AbstractManager;


/**
 * Class UtilisateurLogActionManager
 * @package CoreBundle\Services\Manager
 */
class UtilisateurLogActionManager extends AbstractManager
{
    public function test($item)
    {
        $this->em->persist($item);
    }
}