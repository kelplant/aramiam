<?php
namespace CoreBundle\Entity\Applications\Odigo;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="core_app_odigo_numodigo")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\Applications\Odigo\OdigoTelListeRepository")
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