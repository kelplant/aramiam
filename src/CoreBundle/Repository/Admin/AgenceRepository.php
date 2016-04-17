<?php
namespace CoreBundle\Repository\Admin;

use Doctrine\ORM\EntityRepository;

/**
 * Class AgenceRepository
 * @package CoreBundle\Repository\Admin
 */
class AgenceRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function findAll()
    {
        return $this->findBy(array(), array('name' => 'ASC'));
    }
}