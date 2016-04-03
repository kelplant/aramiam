<?php
namespace CoreBundle\Services\Manager;

use CoreBundle\Entity\Admin\MouvHistory;
use Doctrine\ORM\EntityManager;
use DateTime;

/**
 * Class ParametersManager
 * @package CoreBundle\Services\Manager
 */
class MouvHistoryManager
{
    private $em;

    /**
     * ParametersManager constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager) {
        $this->em = $entityManager;
    }

    public function add($itemLoad,$adminId,$type)
    {
        $itemToSet = new MouvHistory();
        $itemToSet->setUserId($itemLoad['id']);
        $itemToSet->setEntity($itemLoad['entiteHolding']);
        $itemToSet->setAgence($itemLoad['agence']);
        $itemToSet->setService($itemLoad['service']);
        $itemToSet->setFonction($itemLoad['fonction']);
        $itemToSet->setAdminId($adminId);
        $itemToSet->setDateModif(new \Datetime());
        $itemToSet->setType($type);
        $this->em->persist($itemToSet);
        $this->em->flush();
    }


}