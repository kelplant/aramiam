<?php
namespace CoreBundle\Services\Manager\Applications\Odigo;

use CoreBundle\Entity\Applications\Odigo\OrangeTelListe;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Class OrangeTelListeManager
 * @package CoreBundle\Services\Manager\Applications\Odigo
 */
class OrangeTelListeManager
{
    private $managerRegistry;

    private $repository;

    private $em;
    /**
     * MouvHistoryManager constructor.
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(ManagerRegistry $managerRegistry) {
        $this->managerRegistry = $managerRegistry;
        $this->em = $this->managerRegistry->getManagerForClass(OrangeTelListe::class);
    }

    /**
     * @param $service
     * @return mixed
     */
    public function getAllTelForService($service)
    {
        $get = $this->getRepository()->findBy(array('service' => $service, 'inUse' => 0), array('numero' => 'ASC'));
        $listeTel = [];
        for ($i = 0; $i <= count($get) - 1; $i++) {
            $listeTel[$i] = $get[$i]->getNumero();
        }
        return $listeTel;
    }

    /**
     * @param $numTel
     * @return mixed
     */
    public function setNumOrangeInUse($numTel)
    {
        $itemToSet = $this->getRepository()->findOneByNumero($numTel);
        $itemToSet->setInUse('1');
        $this->em->flush();
        return $numTel;
    }

    /**
     * @param $repository
     * @return OdigoTelListeManager
     */
    public function setRepository($repository)
    {
        $this->repository = $repository;
        return $this;
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getRepository()
    {
        return $this->managerRegistry->getManager()->getRepository('CoreBundle:Applications\Odigo\OrangeTelListe');
    }
}