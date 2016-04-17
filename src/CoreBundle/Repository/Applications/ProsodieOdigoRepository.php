<?php
namespace CoreBundle\Repository\Applications;

use Doctrine\ORM\EntityRepository;

/**
 * Class ProsodieOdigoRepository
 * @package CoreBundle\Repository\Applications
 */
class ProsodieOdigoRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function findAll()
    {
        return $this->findBy(array(), array('id' => 'ASC'));
    }
}