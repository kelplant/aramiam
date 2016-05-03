<?php
namespace CoreBundle\Entity\Admin;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class UtilisateurPhoto
 * @ORM\Table(name="core_admin_utilisateurs_photos")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\Admin\UtilisateurPhotoRepository")
 */
class UtilisateurPhoto
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    protected $userId;

    /**
     * @var string
     * @ORM\Column(type="string", length=100)
     */
    protected $mineType;

    /**
     * @var resource
     * @ORM\Column(type="blob"))
     */
    protected $photo;

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     * @return UtilisateurPhoto
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return string
     */
    public function getMineType()
    {
        return $this->mineType;
    }

    /**
     * @param string $mineType
     * @return UtilisateurPhoto
     */
    public function setMineType($mineType)
    {
        $this->mineType = $mineType;
        return $this;
    }

    /**
     * @return resource
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param resource $photo
     * @return UtilisateurPhoto
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
        return $this;
    }
}