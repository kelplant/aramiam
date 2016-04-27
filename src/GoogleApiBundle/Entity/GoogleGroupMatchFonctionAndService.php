<?php
namespace GoogleApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="google_group_match_fonction_service")
 * @ORM\Entity(repositoryClass="GoogleApiBundle\Repository\GoogleGroupMatchFonctionAndServiceRepository")
 */
class GoogleGroupMatchFonctionAndService
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
     * @ORM\Column(type="string", unique=false, nullable=true)
     */
    protected $gmailGroupId;

    /**
     * @var string
     * @ORM\Column(type="string", unique=false, nullable=true)
     */
    protected $fonctionId;

    /**
     * @var string
     * @ORM\Column(type="string", unique=false, nullable=true)
     */
    protected $serviceId;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return GoogleGroupMatchFonctionAndService
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getGmailGroupId()
    {
        return $this->gmailGroupId;
    }

    /**
     * @param string $gmailGroupId
     * @return GoogleGroupMatchFonctionAndService
     */
    public function setGmailGroupId($gmailGroupId)
    {
        $this->gmailGroupId = $gmailGroupId;
        return $this;
    }

    /**
     * @return string
     */
    public function getFonctionId()
    {
        return $this->fonctionId;
    }

    /**
     * @param string $fonctionId
     * @return GoogleGroupMatchFonctionAndService
     */
    public function setFonctionId($fonctionId)
    {
        $this->fonctionId = $fonctionId;
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
     * @return GoogleGroupMatchFonctionAndService
     */
    public function setServiceId($serviceId)
    {
        $this->serviceId = $serviceId;
        return $this;
    }
}