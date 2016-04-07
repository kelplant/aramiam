<?php
namespace CoreBundle\Services\Manager;

use CoreBundle\Entity\Admin\Utilisateur;
use DateTime;

/**
 * Class UtilisateurManager
 * @package CoreBundle\Services\Manager
 */
class UtilisateurManager extends AbstractManager
{
    /**
     * @param $itemLoad
     * @return bool|int
     */
    public function transform($itemLoad) {
        $this->em = $this->setUpEm();
        $itemLoad['idCandidat'] = $itemLoad['id'];
        $itemLoad['isCreateInGmail'] = '0';
        $itemLoad['isCreateInOdigo'] = '0';
        $itemLoad['isCreateInRobusto'] = '0';
        $itemLoad['isCreateInSalesforce'] = '0';
        $itemLoad['email'] = NULL;
        $itemToSet = new Utilisateur();
        try {
            $this->save($this->globalSetItem($itemToSet, $itemLoad));
            return 6669;
        } catch (\Exception $e) {
            return error_log($e->getMessage());
        }
    }

    /**
     * @param $itemLoad
     * @return mixed
     */
    public function createArray($itemLoad) {
        $itemToTransform = $this->getRepository()->findOneById($itemLoad);
        $itemArray = [];
        $itemArray['id'] = $itemToTransform->getId();
        $itemArray['name'] = $itemToTransform->getName();
        $itemArray['surname'] = $itemToTransform->getSurname();
        $itemArray['civilite'] = $itemToTransform->getCivilite();
        $itemArray['startDate'] = $itemToTransform->getStartDate()->format('d-m-Y');
        $itemArray['entiteHolding'] = $itemToTransform->getEntiteHolding();
        $itemArray['agence'] = $itemToTransform->getAgence();
        $itemArray['service'] = $itemToTransform->getService();
        $itemArray['fonction'] = $itemToTransform->getFonction();
        $itemArray['statusPoste'] = $itemToTransform->getStatusPoste();
        $itemArray['predecesseur'] = $itemToTransform->getPredecesseur();
        $itemArray['responsable'] = $itemToTransform->getResponsable();
        $itemArray['matriculeRH'] = $itemToTransform->getMatriculeRH();
        $itemArray['commentaire'] = $itemToTransform->getCommentaire();
        $itemArray['isArchived'] = $itemToTransform->getIsArchived();
        $itemArray['idCandidat'] = $itemToTransform->getIdCandidat();
        $itemArray['isCreateInGmail'] = $itemToTransform->getIsCreateInGmail();
        $itemArray['isCreateInOdigo'] = $itemToTransform->getIsCreateInOdigo();
        $itemArray['isCreateInRobusto'] = $itemToTransform->getIsCreateInRobusto();
        $itemArray['isCreateInSalesforce'] = $itemToTransform->getIsCreateInSalesforce();
        $itemArray['email'] = $itemToTransform->getEmail();

        return $itemArray;
    }

    /**
     * @param Utilisateur $itemToSet
     * @param $itemLoad
     * @return mixed
     */
    public function globalSetItem($itemToSet, $itemLoad) {
        $itemToSet->setCivilite($itemLoad['civilite']);
        $itemToSet->setName($itemLoad['name']);
        $itemToSet->setSurname($itemLoad['surname']);
        $itemToSet->setViewName($itemLoad['surname']." ".$itemLoad['name']);
        $itemToSet->setStartDate(new DateTime($itemLoad['startDate']));
        $itemToSet->setAgence($itemLoad['agence']);
        $itemToSet->setService($itemLoad['service']);
        $itemToSet->setMatriculeRH($itemLoad['matriculeRH']);
        $itemToSet->setEntiteHolding($itemLoad['entiteHolding']);
        $itemToSet->setFonction($itemLoad['fonction']);
        $itemToSet->setResponsable($itemLoad['responsable']);
        $itemToSet->setStatusPoste($itemLoad['statusPoste']);
        $itemToSet->setPredecesseur($itemLoad['predecesseur']);
        $itemToSet->setCommentaire($itemLoad['commentaire']);
        $itemToSet->setIsArchived('0');
        $itemToSet->setIdCandidat($itemLoad['idCandidat']);
        $itemToSet->setIsCreateInGmail($itemLoad['isCreateInGmail']);
        $itemToSet->setIsCreateInOdigo($itemLoad['isCreateInOdigo']);
        $itemToSet->setIsCreateInRobusto($itemLoad['isCreateInRobusto']);
        $itemToSet->setIsCreateInSalesforce($itemLoad['isCreateInSalesforce']);
        $itemToSet->setEmail($itemLoad['email']);

        return $itemToSet;
    }
}