<?php
namespace CoreBundle\Services\Manager;

use Doctrine\ORM\EntityManager;
use CoreBundle\Entity\Service;

/**
 * Class ServiceManager
 * @package CoreBundle\Manager
 */
class ServiceManager extends BaseManager
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
     * @param $serviceId
     * @return null|object
     */
    public function loadService($serviceId) {
        return $this->getRepository()
            ->findOneBy(array('id' => $serviceId));
    }

    /**
     * @param $serviceLoad
     * @return bool|int
     */
    public function setService($serviceLoad)
    {
        $serviceInsert = new Service();
        $serviceInsert->setName($serviceLoad['name']);
        $serviceInsert->setShortName($serviceLoad['shortName']);
        $serviceInsert->setNameInCompany($serviceLoad['nameInCompany']);
        $serviceInsert->setNameInOdigo($serviceLoad['nameInOdigo']);
        $serviceInsert->setNameInSalesforce($serviceLoad['nameInSalesforce']);
        $serviceInsert->setNameInZendesk($serviceLoad['nameInZendesk']);
        try {
            $this->saveService($serviceInsert);
            return $message = 6669;
        } catch (\Exception $e) {
            return $message = error_log($e->getMessage());
        }
    }

    /**
     * @param $service
     * @return bool|int
     */
    public function removeService($service)
    {
        $services = $this->getRepository()->findById($service);
        try {
            foreach ($services as $service) {
                $this->em->remove($service);
                $this->em->flush();
            }
            return $message = 6668;
        } catch (\Exception $e) {
            return $message = error_log($e->getMessage());
        }
    }

    /**
     * @param $serviceEdit
     * @param $serviceLoad
     * @return bool|string
     */
    public function editService($serviceEdit, $serviceLoad)
    {
        try
        {
            $serviceEdit = $this->getRepository()->findOneById($serviceEdit);
            $serviceEdit->setName($serviceLoad['name']);
            $serviceEdit->setShortName($serviceLoad['shortName']);
            $serviceEdit->setNameInCompany($serviceLoad['nameInCompany']);
            $serviceEdit->setNameInOdigo($serviceLoad['nameInOdigo']);
            $serviceEdit->setNameInSalesforce($serviceLoad['nameInSalesforce']);
            $serviceEdit->setNameInZendesk($serviceLoad['nameInZendesk']);
            $this->em->flush();
            return $message = "6667";
        } catch (\Exception $e) {
            return $message = error_log($e->getMessage());
        }
    }

    /**
     * @param Service $service
     */
    public function saveService(Service $service)
    {
        $this->persistAndFlush($service);
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getRepository()
    {
        return $this->em->getRepository('CoreBundle:Service');
    }
}