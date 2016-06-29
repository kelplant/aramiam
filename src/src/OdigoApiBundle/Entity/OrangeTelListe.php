<?php
namespace OdigoApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="odigo_numorange")
 * @ORM\Entity(repositoryClass="OdigoApiBundle\Repository\OrangeTelListeRepository")
 */
class OrangeTelListe extends AbstractNumListe
{

}