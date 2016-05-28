<?php
namespace CoreBundle\Services\Manager\Admin;

use AppBundle\Services\Manager\AbstractManager;
use CoreBundle\Entity\Admin\Candidat;
use DateTime;

/**
 * Class CandidatManager
 * @package CoreBundle\Services\Manager
 */
class CandidatManager extends AbstractManager
{
    /**
     * @param $itemToSet
     * @param $itemLoad
     * @return Candidat
     */
    public function globalSetItem($itemToSet, $itemLoad) {

        $itemToSet->setName($itemLoad['name']);
        $itemToSet->setSurname($itemLoad['surname']);
        $itemToSet->setCivilite($itemLoad['civilite']);
        $itemToSet->setStartDate(new DateTime($itemLoad['startDate']));
        $itemToSet->setMatriculeRH($itemLoad['matriculeRH']);
        $itemToSet->setEntiteHolding($itemLoad['entiteHolding']);
        $itemToSet->setAgence($itemLoad['agence']);
        $itemToSet->setService($itemLoad['service']);
        $itemToSet->setFonction($itemLoad['fonction']);
        $itemToSet->setResponsable($itemLoad['responsable']);
        $itemToSet->setStatusPoste($itemLoad['statusPoste']);
        $itemToSet->setPredecesseur($itemLoad['predecesseur']);
        $itemToSet->setCommentaire($itemLoad['commentaire']);
        $itemToSet->setIsArchived('0');
        $itemToSet->setCreatedDate($itemLoad['createdDate']);

        return $itemToSet;
    }

    /**
     * @param $itemLoad
     * @return mixed
     */
    public function createArray($itemLoad) {
        $itemToTransform = $this->getRepository()->findOneById($itemLoad);
        $itemArray = [];
        $itemArray['id']            = $itemToTransform->getId();
        $itemArray['name']          = $itemToTransform->getName();
        $itemArray['surname']       = $itemToTransform->getSurname();
        $itemArray['civilite']      = $itemToTransform->getCivilite();
        $itemArray['startDate']     = $itemToTransform->getStartDate()->format('d-m-Y');
        $itemArray['entiteHolding'] = $itemToTransform->getEntiteHolding();
        $itemArray['agence']        = $itemToTransform->getAgence();
        $itemArray['service']       = $itemToTransform->getService();
        $itemArray['fonction']      = $itemToTransform->getFonction();
        $itemArray['statusPoste']   = $itemToTransform->getStatusPoste();
        $itemArray['predecesseur']  = $itemToTransform->getPredecesseur();
        $itemArray['responsable']   = $itemToTransform->getResponsable();
        $itemArray['matriculeRH']   = $itemToTransform->getMatriculeRH();
        $itemArray['commentaire']   = $itemToTransform->getCommentaire();
        $itemArray['isArchived']    = $itemToTransform->getIsArchived();
        $itemArray['createdDate']   = (new DateTime($itemToTransform->getCreatedDate()))->format('Y-m-d H:m:s');

        return $itemArray;
    }

    /**
     * @param $itemId
     */
    public function transformUserArchiveCandidat($itemId) {
        $itemToSet = $this->getRepository()->findOneById($itemId);
        $itemToSet->setIsArchived('2');
        $this->em->flush();
    }

    /**
     * @param $itemId
     * @return Candidat
     */
    public function loadCandidat($itemId) {
        return $this->getRepository()
            ->findOneBy(array('id' => $itemId));
    }

    /**
     * @param $isArchived
     * @return mixed
     */
    public function getlist($isArchived)
    {
        $sql = "SELECT a.is_archived as isArchived, a.id, a.name, a.surname, a.start_date, b.agence_name, c.service_name, d.fonction_name FROM aramiam.core_admin_candidats a LEFT JOIN aramiam.core_admin_agences b ON b.id = a.agence  LEFT JOIN aramiam.core_admin_services c ON c.id = a.service LEFT JOIN aramiam.core_admin_fonctions d ON d.id = a.fonction WHERE a.is_archived = ".$isArchived;

        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
