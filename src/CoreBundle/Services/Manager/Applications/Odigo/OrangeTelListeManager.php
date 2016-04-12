<?php
namespace CoreBundle\Services\Manager\Applications\Odigo;

use CoreBundle\Entity\Applications\Odigo\OrangeTelListe;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Class ParametersManager
 * @package CoreBundle\Services\Manager
 */
class OrangeTelListeManager
{
    private $managerRegistry;

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
     * @param $agence
     * @return mixed
     */
    public function getAllTelForAgence($agence)
    {
        $get = $this->em->getRepository('CoreBundle:Applications\Odigo\OrangeTelListe')->findBy(array('agence' => $agence, 'inUse' => 0), array('numero' => 'ASC'));
        $listeTel = [];
        for($i=0; $i <= count($get)-1; $i++) {
            $listeTel[$i] = $get[$i]->getNumero();
        }
        return $listeTel;
    }
}