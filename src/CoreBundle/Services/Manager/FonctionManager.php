<?php
namespace CoreBundle\Services\Manager;

use Doctrine\ORM\EntityManager;
use CoreBundle\Entity\Fonction;

/**
 * Class FonctionManager
 * @package CoreBundle\Manager
 */
class FonctionManager extends BaseManager
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
     * @param $fonctionId
     * @return null|object
     */
    public function loadFonction($fonctionId) {
        return $this->getRepository()
            ->findOneBy(array('id' => $fonctionId));
    }

    /**
     * @param $fonctionLoad
     * @return bool|int
     */
    public function setFonction($fonctionLoad)
    {
        $fonctionInsert = new Fonction();
        $fonctionInsert->setName($fonctionLoad['name']);
        $fonctionInsert->setShortName($fonctionLoad['shortName']);
        $fonctionInsert->setNameInCompany($fonctionLoad['nameInCompany']);
        $fonctionInsert->setNameInOdigo($fonctionLoad['nameInOdigo']);
        $fonctionInsert->setNameInSalesforce($fonctionLoad['nameInSalesforce']);
        $fonctionInsert->setNameInZendesk($fonctionLoad['nameInZendesk']);
        try {
            $this->saveFonction($fonctionInsert);
            return $message = 6669;
        } catch (\Exception $e) {
            return $message = error_log($e->getMessage());
        }
    }

    /**
     * @param $fonction
     * @return bool|int
     */
    public function removeFonction($fonction)
    {
        $fonctions = $this->getRepository()->findById($fonction);
        try {
            foreach ($fonctions as $fonction) {
                $this->em->remove($fonction);
                $this->em->flush();
            }
            return $message = 6668;
        } catch (\Exception $e) {
            return $message = error_log($e->getMessage());
        }
    }

    /**
     * @param $fonctionEdit
     * @param $fonctionLoad
     * @return bool|string
     */
    public function editFonction($fonctionEdit, $fonctionLoad)
    {
        try
        {
            $fonctionEdit = $this->getRepository()->findOneById($fonctionEdit);
            $fonctionEdit->setName($fonctionLoad['name']);
            $fonctionEdit->setShortName($fonctionLoad['shortName']);
            $fonctionEdit->setNameInCompany($fonctionLoad['nameInCompany']);
            $fonctionEdit->setNameInOdigo($fonctionLoad['nameInOdigo']);
            $fonctionEdit->setNameInSalesforce($fonctionLoad['nameInSalesforce']);
            $fonctionEdit->setNameInZendesk($fonctionLoad['nameInZendesk']);
            $this->em->flush();
            return $message = "6667";
        } catch (\Exception $e) {
            return $message = error_log($e->getMessage());
        }
    }

    /**
     * @param Fonction $fonction
     */
    public function saveFonction(Fonction $fonction)
    {
        $this->persistAndFlush($fonction);
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getRepository()
    {
        return $this->em->getRepository('CoreBundle:Fonction');
    }
}