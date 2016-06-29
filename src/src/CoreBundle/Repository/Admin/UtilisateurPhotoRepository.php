<?php
namespace CoreBundle\Repository\Admin;

use Doctrine\ORM\EntityRepository;

/**
 * Class UtilisateurPhotoRepository
 * @package CoreBundle\Repository\Admin
 */
class UtilisateurPhotoRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function findAll()
    {
        return $this->findBy(array(), array('userId' => 'ASC'));
    }
}