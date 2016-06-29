<?php
// AppBundle/Entity/IdEntry.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * @ORM\Entity ()
 * @ORM\Table(name="app_auth_identry")
 */
class IdEntry
{
    /**
     * @var string
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $entityId;

    /**
     * @var string
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $id;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $expiryTimestamp;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $createdAt;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $updatedAt;

    /**
     * @return string
     */
    public function getEntityId()
    {
        return $this->entityId;
    }

    /**
     * @param string $entityId
     * @return IdEntry
     */
    public function setEntityId($entityId)
    {
        $this->entityId = $entityId;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getExpiryTime()
    {
        $dt = new \DateTime();
        $dt->setTimestamp($this->expiryTimestamp);

        return $dt;
    }

    /**
     * @param \DateTime $expiryTime
     * @return IdEntry
     */
    public function setExpiryTime(\DateTime $expiryTime)
    {
        $this->expiryTimestamp = $expiryTime->getTimestamp();

        return $this;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return IdEntry
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getExpiryTimestamp()
    {
        return $this->expiryTimestamp;
    }

    /**
     * @param int $expiryTimestamp
     * @return IdEntry
     */
    public function setExpiryTimestamp($expiryTimestamp)
    {
        $this->expiryTimestamp = $expiryTimestamp;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     * @return IdEntry
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime $updatedAt
     * @return IdEntry
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}