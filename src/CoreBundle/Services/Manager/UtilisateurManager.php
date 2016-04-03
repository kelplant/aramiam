<?php
namespace CoreBundle\Services\Manager;

use CoreBundle\Entity\Admin\Utilisateur;

/**
 * Class UtilisateurManager
 * @package CoreBundle\Services\Manager
 */
class UtilisateurManager extends AbstractManager
{
    /**
     * @param $itemLoad
     * @return Utilisateur
     */
    public function transform($itemLoad)
    {
        $itemToSet = new Utilisateur();
        $itemToSet->setCivilite($itemLoad['civilite']);
        $itemToSet->setName($itemLoad['name']);
        $itemToSet->setSurname($itemLoad['surname']);
        $itemToSet->setViewName($itemLoad['surname']." ".$itemLoad['name']);
        $itemToSet->setStartDate(new \DateTime($itemLoad['startDate']));
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
        $itemToSet->setIdCandidat($itemLoad['id']);
        $itemToSet->setIsCreateInGmail('0');
        $itemToSet->setIsCreateInOdigo('0');
        $itemToSet->setIsCreateInRobusto('0');
        $itemToSet->setIsCreateInSalesforce('0');
        $itemToSet->setEmail(NULL);

        try {
            $this->save($itemToSet);
            return 6669;
        } catch (\Exception $e) {
            return error_log($e->getMessage());
        }
    }
}