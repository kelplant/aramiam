<?php
namespace CoreBundle\Services\Manager;

use CoreBundle\Entity\Utilisateur;

/**
 * Class AgenceManager
 * @package CoreBundle\Manager
 */
class UtilisateurManager extends AbstractManager
{
    /**
     * @param $utilisateurId
     * @return null|object
     */
    public function loadAgence($utilisateurId) {
        return $this->getRepository()
            ->findOneBy(array('id' => $utilisateurId));
    }

    /**
     * @param Utilisateur $utilisateur
     */
    public function saveAgence(Utilisateur $utilisateur)
    {
        $this->persistAndFlush($utilisateur);
    }
}