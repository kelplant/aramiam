<?php
namespace CoreBundle\Repository\Admin;

use Doctrine\ORM\EntityRepository;

/**
 * Class UtilisateurRepository
 * @package CoreBundle\Repository\Admin
 */
class UtilisateurRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function findAll()
    {
        return $this->findBy(array(), array('name' => 'ASC'));
    }
}