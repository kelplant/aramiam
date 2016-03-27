<?php
namespace CoreBundle\Services\Manager;

use Doctrine\ORM\EntityManager;
use CoreBundle\Entity\Agence;

/**
 * Class AgenceManager
 * @package CoreBundle\Manager
 */
class AgenceManager extends BaseManager
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
     * @param $agenceId
     * @return null|object
     */
    public function loadAgence($agenceId) {
        return $this->getRepository()
            ->findOneBy(array('id' => $agenceId));
    }

    /**
     * @param $agenceLoad
     * @return bool|int
     */
    public function setAgence($agenceLoad)
    {
        $agenceInsert = new Agence();
        $agenceInsert->setName($agenceLoad['name']);
        $agenceInsert->setNameInCompany($agenceLoad['nameInCompany']);
        $agenceInsert->setNameInOdigo($agenceLoad['nameInOdigo']);
        $agenceInsert->setNameInSalesforce($agenceLoad['nameInSalesforce']);
        $agenceInsert->setNameInZendesk($agenceLoad['nameInZendesk']);
        try{
            $this->saveAgence($agenceInsert);
            return $message = 6669;
        } catch(\Exception $e){
            return $message = error_log($e->getMessage());
        }
    }

    /**
     * @param $agence
     * @return bool|int
     */
    public function removeAgence($agence)
    {
        $agences = $this->getRepository()->findById($agence);
        try{
            foreach ($agences as $agence) {
                $this->em->remove($agence);
                $this->em->flush();
            }
            return $message = 6668;
        } catch(\Exception $e){
            return $message = error_log($e->getMessage());
        }
    }

    /**
     * @param $agenceEdit
     * @param $agenceLoad
     * @return bool|string
     */
    public function editAgence($agenceEdit,$agenceLoad)
    {
        try
        {
            $agenceEdit = $this->getRepository()->findOneById($agenceEdit);
            $agenceEdit->setName($agenceLoad['name']);
            $agenceEdit->setNameInCompany($agenceLoad['nameInCompany']);
            $agenceEdit->setNameInOdigo($agenceLoad['nameInOdigo']);
            $agenceEdit->setNameInSalesforce($agenceLoad['nameInSalesforce']);
            $agenceEdit->setNameInZendesk($agenceLoad['nameInZendesk']);
            $this->em->flush();
            return $message = "6667";
        } catch(\Exception $e){
            return $message = error_log($e->getMessage());
        }
    }
    /**
     * @param Agence $agence
     */
    public function saveAgence(Agence $agence)
    {
        $this->persistAndFlush($agence);
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getRepository()
    {
        return $this->em->getRepository('CoreBundle:Agence');
    }
}