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
 * Class AramisRobusto
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\ApplicationRepository")
 * @ORM\Table(name="app_robusto")
 */
class AramisRobusto
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
    protected $robustoProfil;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $robustoEndDate;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return AramisRobusto
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
     * @return AramisRobusto
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return string
     */
    public function getRobustoProfil()
    {
        return $this->robustoProfil;
    }

    /**
     * @param string $robustoProfil
     * @return AramisRobusto
     */
    public function setRobustoProfil($robustoProfil)
    {
        $this->robustoProfil = $robustoProfil;
        return $this;
    }

    /**
     * @return string
     */
    public function getRobustoEndDate()
    {
        return $this->robustoEndDate;
    }

    /**
     * @param string $robustoEndDate
     * @return AramisRobusto
     */
    public function setRobustoEndDate($robustoEndDate)
    {
        $this->robustoEndDate = $robustoEndDate;
        return $this;
    }
}