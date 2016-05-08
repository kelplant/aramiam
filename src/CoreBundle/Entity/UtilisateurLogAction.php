<?php
namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * Class UtilisateurLogAction
 * @ORM\Entity()
 * @ORM\Table(name="core_utilisateur_log_action")
 */
class UtilisateurLogAction
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
    protected $requesterId;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $utilisateurId;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $timestamp;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $field;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    protected $oldString;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    protected $newString;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return UtilisateurLogAction
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getRequesterId()
    {
        return $this->requesterId;
    }

    /**
     * @param int $requesterId
     * @return UtilisateurLogAction
     */
    public function setRequesterId($requesterId)
    {
        $this->requesterId = $requesterId;
        return $this;
    }

    /**
     * @return int
     */
    public function getUtilisateurId()
    {
        return $this->utilisateurId;
    }

    /**
     * @param int $utilisateurId
     * @return UtilisateurLogAction
     */
    public function setUtilisateurId($utilisateurId)
    {
        $this->utilisateurId = $utilisateurId;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param DateTime $timestamp
     * @return UtilisateurLogAction
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * @return resource
     */
    public function getOldString()
    {
        return $this->oldString;
    }

    /**
     * @param resource $oldString
     * @return UtilisateurLogAction
     */
    public function setOldString($oldString)
    {
        $this->oldString = $oldString;
        return $this;
    }

    /**
     * @return resource
     */
    public function getNewString()
    {
        return $this->newString;
    }

    /**
     * @param resource $newString
     * @return UtilisateurLogAction
     */
    public function setNewString($newString)
    {
        $this->newString = $newString;
        return $this;
    }

    /**
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @param string $field
     * @return UtilisateurLogAction
     */
    public function setField($field)
    {
        $this->field = $field;
        return $this;
    }
}