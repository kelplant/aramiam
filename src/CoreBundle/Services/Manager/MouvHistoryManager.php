<?php
namespace CoreBundle\Services\Manager;

use CoreBundle\Entity\Admin\MouvHistory;
use Doctrine\Common\Persistence\ManagerRegistry;
use DateTime;

/**
 * Class MouvHistoryManager
 * @package CoreBundle\Services\Manager
 */
class MouvHistoryManager
{
    private $managerRegistry;

    private $em;

    /**
     * MouvHistoryManager constructor.
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(ManagerRegistry $managerRegistry) {
        $this->managerRegistry = $managerRegistry;
        $this->em = $this->managerRegistry->getManagerForClass(MouvHistory::class);
    }

    public function add($itemLoad, $adminId, $type)
    {
        $itemToSet = new MouvHistory();
        $itemToSet->setUserId($itemLoad['id']);
        $itemToSet->setEntity($itemLoad['entiteHolding']);
        $itemToSet->setAgence($itemLoad['agence']);
        $itemToSet->setService($itemLoad['service']);
        $itemToSet->setFonction($itemLoad['fonction']);
        $itemToSet->setAdminId($adminId);
        $itemToSet->setDateModif(new Datetime());
        $itemToSet->setType($type);
        $this->persistAndFlush($itemToSet);
    }

    /**
     * @param MouvHistory $mouvHistory
     */
    private function persistAndFlush(MouvHistory $mouvHistory)
    {
        $this->em->persist($mouvHistory);
        $this->em->flush();
    }

}