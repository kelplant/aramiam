<?php
namespace DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * @ORM\Table(name="dashboard_todo_events")
 * @ORM\Entity()
 */
class DashboardTodoListEvent
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer", unique=true)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    protected $name;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $comment;

    /**
     * @var DateTime
     * @ORM\Column(type="date", nullable=false)
     */
    protected $createDate;

    /**
     * @var boolean
     * @ORM\Column(type="boolean", length=255, nullable=false, options={"default":0})
     */
    protected $isDone;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return DashboardTodoListEvent
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return DashboardTodoListEvent
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     * @return DashboardTodoListEvent
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    /**
     * @param DateTime $createDate
     * @return DashboardTodoListEvent
     */
    public function setCreateDate($createDate)
    {
        $this->createDate = $createDate;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getIsDone()
    {
        return $this->isDone;
    }

    /**
     * @param boolean $isDone
     * @return DashboardTodoListEvent
     */
    public function setIsDone($isDone)
    {
        $this->isDone = $isDone;
        return $this;
    }
}