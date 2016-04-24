<?php
namespace SalesforceApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="salesforce_territory_match_service")
 * @ORM\Entity(repositoryClass="SalesforceApiBundle\Repository\SalesforceTerritoryMatchServiceRepository")
 */
class SalesforceTerritoryMatchService
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $serviceId;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $salesforceTerritoryId;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return SalesforceTerritoryMatchService
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getServiceId()
    {
        return $this->serviceId;
    }

    /**
     * @param string $serviceId
     * @return SalesforceTerritoryMatchService
     */
    public function setServiceId($serviceId)
    {
        $this->serviceId = $serviceId;
        return $this;
    }

    /**
     * @return string
     */
    public function getSalesforceTerritoryId()
    {
        return $this->salesforceTerritoryId;
    }

    /**
     * @param string $salesforceTerritoryId
     * @return SalesforceTerritoryMatchService
     */
    public function setSalesforceTerritoryId($salesforceTerritoryId)
    {
        $this->salesforceTerritoryId = $salesforceTerritoryId;
        return $this;
    }
}