<?php
namespace CoreBundle\Services\Manager\Applications\Odigo;

use CoreBundle\Entity\Applications\Odigo\OdigoTelListe;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Class OdigoTelListeManager
 * @package CoreBundle\Services\Manager\Applications\Odigo
 */
class OdigoTelListeManager
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
        $this->em = $this->managerRegistry->getManagerForClass(OdigoTelListe::class);
    }

    /**
     * @param $service
     * @param $fonction
     * @return mixed
     */
    public function getAllTelForServiceAndFonction($service, $fonction)
    {
        $get = $this->getRepository()->findBy(array('service' => $service, 'fonction' => $fonction, 'inUse' => 0), array('numero' => 'ASC'));
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
    public function setNumProsodieInUse($numTel)
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
        return $this->managerRegistry->getManager()->getRepository('CoreBundle:Applications\Odigo\OdigoTelListe');
    }
}