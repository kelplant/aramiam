<?php
namespace SalesforceApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="core_app_salesforce_scloud_acces")
 * @ORM\Entity(repositoryClass="SalesforceApiBundle\Repository\SalesforceServiceCloudAccesRepository")
 */
class SalesforceServiceCloudAcces
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
     * @ORM\Column(type="integer", unique=true)
     */
    protected $fonctionId;

    /**
     * @var string
     * @ORM\Column(type="boolean")
     */
    protected $status;
}