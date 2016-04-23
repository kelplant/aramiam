<?php
namespace SalesforceApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="salesforce_scloud_acces")
 * @ORM\Entity(repositoryClass="SalesforceApiBundle\Repository\SalesforceServiceCloudAccesRepository")
 */
class SalesforceServiceCloudAcces
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="boolean")
     */
    protected $status;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return SalesforceServiceCloudAcces
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return SalesforceServiceCloudAcces
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }
}