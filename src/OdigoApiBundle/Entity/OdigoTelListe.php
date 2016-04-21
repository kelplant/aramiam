<?php
namespace OdigoApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="core_app_odigo_numodigo")
 * @ORM\Entity(repositoryClass="OdigoApiBundle\Repository\OdigoTelListeRepository")
 */
class OdigoTelListe extends AbstractNumListe
{
    /**
     * @var string
     * @ORM\Column(type="integer"))
     */
    protected $fonction;

    /**
     * @return string
     */
    public function getFonction()
    {
        return $this->fonction;
    }

    /**
     * @param string $fonction
     * @return OdigoTelListe
     */
    public function setFonction($fonction)
    {
        $this->fonction = $fonction;
        return $this;
    }
}