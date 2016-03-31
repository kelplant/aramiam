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
        $itemToSet->setIsArchived('0');

        try {
            $this->save($itemToSet);
            return 6669;
        } catch (\Exception $e) {
            return error_log($e->getMessage());
        }
    }
}
