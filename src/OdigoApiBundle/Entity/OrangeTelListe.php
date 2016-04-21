<?php
namespace OdigoApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="core_app_odigo_numorange")
 * @ORM\Entity(repositoryClass="OdigoApiBundle\Repository\OrangeTelListeRepository")
 */
class OrangeTelListe extends AbstractNumListe
{

}