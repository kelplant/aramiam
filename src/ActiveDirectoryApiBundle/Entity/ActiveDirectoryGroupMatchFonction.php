<?php
namespace ActiveDirectoryApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="active_directory_groupe_match_fonction")
 * @ORM\Entity(repositoryClass="ActiveDirectoryApiBundle\Repository\ActiveDirectoryGroupMatchFonctionRepository")
 */
class ActiveDirectoryGroupMatchFonction
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
    protected $fonctionId;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $activeDirectoryGroupId;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return ActiveDirectoryGroupMatchFonction
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * @return ActiveDirectoryGroupMatchFonction
     */
    public function setFonctionId($fonctionId)
    {
        $this->fonctionId = $fonctionId;
        return $this;
    }

    /**
     * @return string
     */
    public function getActiveDirectoryGroupId()
    {
        return $this->activeDirectoryGroupId;
    }

    /**
     * @param string $activeDirectoryGroupId
     * @return ActiveDirectoryGroupMatchFonction
     */
    public function setActiveDirectoryGroupId($activeDirectoryGroupId)
    {
        $this->activeDirectoryGroupId = $activeDirectoryGroupId;
        return $this;
    }
}