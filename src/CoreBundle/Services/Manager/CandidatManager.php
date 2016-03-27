<?php
namespace CoreBundle\Services\Manager;

use Doctrine\ORM\EntityManager;
use CoreBundle\Entity\Candidat;

/**
 * Class CandidatManager
 * @package CoreBundle\Manager
 */
class CandidatManager extends BaseManager
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * AgencesManager constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param $candidatId
     * @return null|object
     */
    public function loadCandidat($candidatId) {
        return $this->getRepository()
            ->findOneBy(array('id' => $candidatId));
    }

    /**
     * @param $candidatLoad
     * @return bool|int
     */
    public function setCandidat($candidatLoad)
    {
        $candidatInsert = new Candidat();
        $candidatInsert->setName($candidatLoad['name']);
        $candidatInsert->setSurname($candidatLoad['surname']);
        $candidatInsert->setCivilite($candidatLoad['civilite']);
        $candidatInsert->setStartDate($candidatLoad['startDate']);
        $candidatInsert->setAgence($candidatLoad['agence']);
        $candidatInsert->setService($candidatLoad['service']);
        $candidatInsert->setFonction($candidatLoad['fonction']);
        $candidatInsert->setResponsable($candidatLoad['responsable']);
        $candidatInsert->setIsArchived($candidatLoad['isArchives']);
        try {
            $this->saveCandidat($candidatInsert);
            return $message = 6669;
        } catch (\Exception $e) {
            return $message = error_log($e->getMessage());
        }
    }

    /**
     * @param $candidat
     * @return bool|int
     */
    public function removeCandidat($candidat)
    {
        $candidats = $this->getRepository()->findById($candidat);
        try {
            foreach ($candidats as $candidat) {
                $this->em->remove($candidat);
                $this->em->flush();
            }
            return $message = 6668;
        } catch (\Exception $e) {
            return $message = error_log($e->getMessage());
        }
    }

    /**
     * @param $candidatEdit
     * @param $candidatLoad
     * @return bool|string
     */
    public function editCandidat($candidatEdit, $candidatLoad)
    {
        try
        {
            $candidatEdit = $this->getRepository()->findOneById($candidatEdit);
            $candidatEdit->setName($candidatLoad['name']);
            $candidatEdit->setSurname($candidatLoad['surname']);
            $candidatEdit->setCivilite($candidatLoad['civilite']);
            $candidatEdit->setStartDate($candidatLoad['startDate']);
            $candidatEdit->setAgence($candidatLoad['agence']);
            $candidatEdit->setService($candidatLoad['service']);
            $candidatEdit->setFonction($candidatLoad['fonction']);
            $candidatEdit->setResponsable($candidatLoad['responsable']);
            $candidatEdit->setIsArchived($candidatLoad['isArchives']);
            $this->em->flush();
            return $message = "6667";
        } catch (\Exception $e) {
            return $message = error_log($e->getMessage());
        }
    }

    /**
     * @param Candidat $candidat
     */
    public function saveCandidat(Candidat $candidat)
    {
        $this->persistAndFlush($candidat);
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getRepository()
    {
        return $this->em->getRepository('CoreBundle:Candidat');
    }
}