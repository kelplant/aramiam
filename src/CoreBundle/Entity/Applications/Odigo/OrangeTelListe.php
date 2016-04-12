<?php
namespace CoreBundle\Entity\Applications\Odigo;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="core_app_odigo_numorange")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\Applications\Odigo\OrangeTelListeRepository")
 */
class OrangeTelListe extends AbstractNumListe
{

}