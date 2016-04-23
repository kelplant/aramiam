<?php
namespace OdigoApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * Class ProsodieOdigo
 * @ORM\Entity(repositoryClass="OdigoApiBundle\Repository\ProsodieOdigoRepository")
 * @ORM\Table(name="odigo_link_user")
 */
class ProsodieOdigo
{
    /** @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="integer", unique=true)
     */
    protected $user;

    /**
     * @var string
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    protected $odigoPhoneNumber;

    /**
     * @var string
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    protected $redirectPhoneNumber;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $odigoExtension;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return ProsodieOdigo
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param string $user
     * @return ProsodieOdigo
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return string
     */
    public function getOdigoPhoneNumber()
    {
        return $this->odigoPhoneNumber;
    }

    /**
     * @param string $odigoPhoneNumber
     * @return ProsodieOdigo
     */
    public function setOdigoPhoneNumber($odigoPhoneNumber)
    {
        $this->odigoPhoneNumber = $odigoPhoneNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getRedirectPhoneNumber()
    {
        return $this->redirectPhoneNumber;
    }

    /**
     * @param string $redirectPhoneNumber
     * @return ProsodieOdigo
     */
    public function setRedirectPhoneNumber($redirectPhoneNumber)
    {
        $this->redirectPhoneNumber = $redirectPhoneNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getOdigoExtension()
    {
        return $this->odigoExtension;
    }

    /**
     * @param string $odigoExtension
     * @return ProsodieOdigo
     */
    public function setOdigoExtension($odigoExtension)
    {
        $this->odigoExtension = $odigoExtension;
        return $this;
    }
}