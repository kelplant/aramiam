<?php
namespace CoreBundle\Entity\Applications\Odigo;

use Doctrine\ORM\Mapping as ORM;

abstract class AbstractNumListe
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
     * @ORM\Column(type="string", length=10)
     */
    protected $numero;

    /**
     * @var string
     * @ORM\Column(type="integer"))
     */
    protected $agence;

    /**
     * @var string
     * @ORM\Column(type="boolean"))
     */
    protected $inUse;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return AbstractNumListe
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * @param string $numero
     * @return AbstractNumListe
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
        return $this;
    }

    /**
     * @return string
     */
    public function getAgence()
    {
        return $this->agence;
    }

    /**
     * @param string $agence
     * @return AbstractNumListe
     */
    public function setAgence($agence)
    {
        $this->agence = $agence;
        return $this;
    }

    /**
     * @return string
     */
    public function getInUse()
    {
        return $this->inUse;
    }

    /**
     * @param string $inUse
     * @return AbstractNumListe
     */
    public function setInUse($inUse)
    {
        $this->inUse = $inUse;
        return $this;
    }
}