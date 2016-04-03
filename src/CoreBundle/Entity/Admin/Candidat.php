<?php
namespace CoreBundle\Entity\Admin;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Candidat
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\Admin\CandidatRepository")
 * @ORM\Table(name="core_admin_candidats")
 */
class Candidat extends AbstractPerson
{

}