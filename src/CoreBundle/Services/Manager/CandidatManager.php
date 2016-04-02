<?php
namespace CoreBundle\Services\Manager;

use CoreBundle\Entity\Admin\Candidat;
use DateTime;

/**
 * Class CandidatManager
 * @package CoreBundle\Manager
 */
class CandidatManager extends AbstractManager
{
    /**
     * @param $itemToSet
     * @param $itemLoad
     * @return Candidat
     */
    public function globalSetItem($itemToSet, $itemLoad)
    {
        $itemToSet->setName($itemLoad['name']);
        $itemToSet->setSurname($itemLoad['surname']);
        $itemToSet->setCivilite($itemLoad['civilite']);
        $itemToSet->setStartDate(new \DateTime($itemLoad['startDate']));
        $itemToSet->setAgence($itemLoad['agence']);
        $itemToSet->setService($itemLoad['service']);
        $itemToSet->setMatriculeRH($itemLoad['matriculeRH']);
        $itemToSet->setFonction($itemLoad['fonction']);
        $itemToSet->setResponsable($itemLoad['responsable']);
        $itemToSet->setStatusPoste($itemLoad['statusPoste']);
        $itemToSet->setPredecesseur($itemLoad['predecesseur']);
        $itemToSet->setCommentaire($itemLoad['commentaire']);
        $itemToSet->setIsArchived('0');
        return $itemToSet;
    }

    /**
     * @param $itemLoad
     * @return bool|int
     */
    public function add($itemLoad)
    {

        $itemToSet = new $this->entity;
        $itemToSet->setName($itemLoad->getName());
        $itemToSet->setSurname($itemLoad->getSurname());
        $itemToSet->setCivilite($itemLoad->getCivilite());
        $itemToSet->setStartDate(new \DateTime($itemLoad->getStartDate()));
        $itemToSet->setAgence($itemLoad->getAgence());
        $itemToSet->setService($itemLoad->getService());
        $itemToSet->setMatriculeRH($itemLoad->getMatriculeRH());
        $itemToSet->setFonction($itemLoad->getFonction());
        $itemToSet->setResponsable($itemLoad->getResponsable());
        $itemToSet->setStatusPoste($itemLoad->getStatusPoste());
        $itemToSet->setPredecesseur($itemLoad->getPredecesseur());
        $itemToSet->setCommentaire($itemLoad->getCommentaire());
        $itemToSet->setIsArchived('0');

        try {
            $this->save($itemToSet);
            return 6669;
        } catch (\Exception $e) {
            return error_log($e->getMessage());
        }
    }

    /**
     * @param $itemLoad
     * @return mixed
     */
    public function createArray($itemLoad)
    {
        $itemToTransform = $this->getRepository()->findOneById($itemLoad);
        $itemArray = [];
        $itemArray['id'] = $itemToTransform->getId();
        $itemArray['name'] = $itemToTransform->getName();
        $itemArray['surname'] = $itemToTransform->getSurname();
        $itemArray['civilite'] = $itemToTransform->getCivilite();
        $itemArray['startDate'] = $itemToTransform->getStartDate()->format('d-m-Y');
        $itemArray['agence'] = $itemToTransform->getAgence();
        $itemArray['service'] = $itemToTransform->getService();
        $itemArray['fonction'] = $itemToTransform->getFonction();
        $itemArray['statusPoste'] = $itemToTransform->getStatusPoste();
        $itemArray['predecesseur'] = $itemToTransform->getPredecesseur();
        $itemArray['responsable'] = $itemToTransform->getResponsable();
        $itemArray['matriculeRH'] = $itemToTransform->getMatriculeRH();
        $itemArray['commentaire'] = $itemToTransform->getCommentaire();
        $itemArray['isArchived'] = $itemToTransform->getIsArchived();

        return $itemArray;
    }
}
