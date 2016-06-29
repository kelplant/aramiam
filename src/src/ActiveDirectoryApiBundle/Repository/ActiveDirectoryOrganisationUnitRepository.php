<?php
namespace ActiveDirectoryApiBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class ActiveDirectoryOrganisationUnitRepository
 * @package ActiveDirectoryApiBundle\Repository
 */
class ActiveDirectoryOrganisationUnitRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function findAll()
    {
        return $this->findBy(array(), array('name' => 'ASC'));
    }
}