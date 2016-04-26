<?php
namespace GoogleApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="google_groupes")
 * @ORM\Entity(repositoryClass="GoogleApiBundle\Repository\GoogleGroupRepository")
 */
class GoogleGroup
{
    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(type="string", unique=true)
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=100, unique=true)
     */
    protected $name;

    /**
     * @var string
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $email;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return GoogleGroup
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
     * @return GoogleGroup
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return GoogleGroup
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }
}