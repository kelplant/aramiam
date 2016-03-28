<?php
/**
 * Created by PhpStorm.
 * User: Xavier
 * Date: 28/03/2016
 * Time: 22:18
 */
namespace CoreBundle\Entity\Applications;

use Doctrine\ORM\Mapping as ORM;
/**
 * Class GoogleGmail
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\ApplicationRepository")
 * @ORM\Table(name="app_gmail")
 */
class GoogleGmail
{
    /** @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="integer")
     */
    protected $user;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $email;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return GoogleGmail
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
     * @return GoogleGmail
     */
    public function setUser($user)
    {
        $this->user = $user;
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
     * @return GoogleGmail
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }
}