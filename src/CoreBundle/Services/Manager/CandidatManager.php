<?php
namespace CoreBundle\Services\Manager;

use Doctrine\ORM\EntityManager;
use CoreBundle\Entity\Candidat;
use \DateTime;

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

    protected $entity;

    protected $entityName;

    /**
     * AgencesManager constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->entity = Candidat::class;
        $this->entityName = 'Candidat';
    }

    /**
     * @param Candidat $candidat
     */
    public function save(Candidat $candidat)
    {
        $this->persistAndFlush($candidat);
    }

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
        $itemToSet->setFonction($itemLoad['fonction']);
        $itemToSet->setResponsable($itemLoad['responsable']);
        $itemToSet->setIsArchived('0');
        return $itemToSet;
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getRepository()
    {
        return $this->em->getRepository('CoreBundle:'.$this->entityName);
    }

    /**
     * @param $itemId
     * @return null|object
     */
    public function load($itemId) {
        return $this->getRepository()
            ->findOneBy(array('id' => $itemId));
    }

    /**
     * @param $itemLoad
     * @return bool|int
     */
    public function add($itemLoad)
    {
        $itemToSet = new $this->entity;
        $itemToSet = $this->globalSetItem($itemToSet, $itemLoad);

        try {
            $this->save($itemToSet);
            return $message = 6669;
        } catch (\Exception $e) {
            return error_log($e->getMessage());
        }
    }

    /**
     * @param $itemId
     * @return bool|int
     */
    public function remove($itemId)
    {
        $itemToSet = $this->getRepository()->findOneById($itemId);
        try {
            $itemToSet->setIsArchived('1');
            $this->em->flush();
            return $message = 6668;
        } catch (\Exception $e) {
            return error_log($e->getMessage());
        }
    }

    /**
     * @param $itemId
     * @param $itemLoad
     * @return bool|string
     */
    public function edit($itemId, $itemLoad)
    {
        try
        {
            $itemToSet = $this->getRepository()->findOneById($itemId);
            $this->globalSetItem($itemToSet, $itemLoad);
            $this->em->flush();
            return $message = "6667";
        } catch (\Exception $e) {
            return error_log($e->getMessage());
        }
    }
}
