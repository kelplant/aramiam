<?php
namespace OdigoApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="odigo_numodigo")
 * @ORM\Entity(repositoryClass="OdigoApiBundle\Repository\OdigoTelListeRepository")
 */
class OdigoTelListe extends AbstractNumListe
{
    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $fonction;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $type;

    /**
     * @return int
     */
    public function getFonction()
    {
        return $this->fonction;
    }

    /**
     * @param int $fonction
     * @return OdigoTelListe
     */
    public function setFonction($fonction)
    {
        $this->fonction = $fonction;
        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return OdigoTelListe
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }
}