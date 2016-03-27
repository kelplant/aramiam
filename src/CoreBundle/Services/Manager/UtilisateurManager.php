<?php
namespace CoreBundle\Services\Manager;

use Doctrine\ORM\EntityManager;
use CoreBundle\Entity\Utilisateur;

/**
 * Class AgenceManager
 * @package CoreBundle\Manager
 */
class UtilisateurManager extends BaseManager
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

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getRepository()
    {
        return $this->em->getRepository('CoreBundle:Utilisateur');
    }
}