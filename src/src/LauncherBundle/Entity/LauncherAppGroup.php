<?php
namespace LauncherBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * Class LauncherAppGroup
 * @ORM\Entity()
 * @ORM\Table(name="user_launcher_app_groups")
 */
class LauncherAppGroup
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /** @var string
     * @ORM\Column(type="string", length=150)
     */
    protected $groupName;

    /** @var int
     * @ORM\Column(type="integer")
     */
    protected $groupOrder;

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
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return LauncherAppGroup
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getGroupName()
    {
        return $this->groupName;
    }

    /**
     * @param string $groupName
     * @return LauncherAppGroup
     */
    public function setGroupName($groupName)
    {
        $this->groupName = $groupName;
        return $this;
    }

    /**
     * @return int
     */
    public function getGroupOrder()
    {
        return $this->groupOrder;
    }

    /**
     * @param int $groupOrder
     * @return LauncherAppGroup
     */
    public function setGroupOrder($groupOrder)
    {
        $this->groupOrder = $groupOrder;
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
     * @return LauncherAppGroup
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
     * @return LauncherAppGroup
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}