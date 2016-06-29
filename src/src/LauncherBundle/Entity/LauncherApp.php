<?php
namespace LauncherBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * Class LauncherApp
 * @ORM\Entity()
 * @ORM\Table(name="user_launcher_apps")
 */
class LauncherApp
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /** @var string
     * @ORM\Column(type="string", length=100)
     */
    protected $appName;

    /** @var string
     * @ORM\Column(type="string", length=2)
     */
    protected $titleHeight;

    /** @var string
     * @ORM\Column(type="string")
     */
    protected $appDescription;

    /** @var int
     * @ORM\Column(type="integer")
     */
    protected $tilesLenght;

    /** @var string
     * @ORM\Column(type="string", length=20)
     */
    protected $tilesColor;

    /** @var string
     * @ORM\Column(type="string")
     */
    protected $icon;

    /** @var int
     * @ORM\Column(type="integer")
     */
    protected $groupId;

    /** @var int
     * @ORM\Column(type="integer")
     */
    protected $tilesOrder;

    /** @var string
     * @ORM\Column(type="string")
     */
    protected $urlLink;

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
     * @return LauncherApp
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getAppName()
    {
        return $this->appName;
    }

    /**
     * @param string $appName
     * @return LauncherApp
     */
    public function setAppName($appName)
    {
        $this->appName = $appName;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitleHeight()
    {
        return $this->titleHeight;
    }

    /**
     * @param string $titleHeight
     * @return LauncherApp
     */
    public function setTitleHeight($titleHeight)
    {
        $this->titleHeight = $titleHeight;
        return $this;
    }

    /**
     * @return int
     */
    public function getGroupId()
    {
        return $this->groupId;
    }

    /**
     * @param int $groupId
     * @return LauncherApp
     */
    public function setGroupId($groupId)
    {
        $this->groupId = $groupId;
        return $this;
    }

    /**
     * @return string
     */
    public function getAppDescription()
    {
        return $this->appDescription;
    }

    /**
     * @param string $appDescription
     * @return LauncherApp
     */
    public function setAppDescription($appDescription)
    {
        $this->appDescription = $appDescription;
        return $this;
    }

    /**
     * @return int
     */
    public function getTilesLenght()
    {
        return $this->tilesLenght;
    }

    /**
     * @param int $tilesLenght
     * @return LauncherApp
     */
    public function setTilesLenght($tilesLenght)
    {
        $this->tilesLenght = $tilesLenght;
        return $this;
    }

    /**
     * @return string
     */
    public function getTilesColor()
    {
        return $this->tilesColor;
    }

    /**
     * @param string $tilesColor
     * @return LauncherApp
     */
    public function setTilesColor($tilesColor)
    {
        $this->tilesColor = $tilesColor;
        return $this;
    }

    /**
     * @return int
     */
    public function getTilesOrder()
    {
        return $this->tilesOrder;
    }

    /**
     * @param int $tilesOrder
     * @return LauncherApp
     */
    public function setTilesOrder($tilesOrder)
    {
        $this->tilesOrder = $tilesOrder;
        return $this;
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param string $icon
     * @return LauncherApp
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrlLink()
    {
        return $this->urlLink;
    }

    /**
     * @param string $urlLink
     * @return LauncherApp
     */
    public function setUrlLink($urlLink)
    {
        $this->urlLink = $urlLink;
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
     * @return LauncherApp
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
     * @return LauncherApp
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}