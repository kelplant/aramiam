<?php
namespace CoreBundle\Services\Manager\Applications\Odigo;

use CoreBundle\Entity\Applications\Odigo\OdigoTelListe;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Class ParametersManager
 * @package CoreBundle\Services\Manager
 */
class OdigoTelListeManager
{
    private $managerRegistry;

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
     * @param $agence
     * @param $fonction
     * @return mixed
     */
    public function getAllTelForAgenceAndFonction($agence, $fonction)
    {
        $get = $this->em->getRepository('CoreBundle:Applications\Odigo\OdigoTelListe')->findBy(array('agence' => $agence, 'fonction' => $fonction, 'inUse' => 0), array('numero' => 'ASC'));
        $listeTel = [];
        for($i=0; $i <= count($get)-1; $i++) {
            $listeTel[$i] = $get[$i]->getNumero();
        }
        return $listeTel;
    }
}