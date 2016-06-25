<?php
namespace CoreBundle\Services\Manager\Admin;

use AppBundle\Services\Manager\AbstractManager;

class CandidatRecruteurLinkManager extends AbstractManager
{
    /**
     * @param $candidatId
     * @return object|null
     */
    public function loadByCandidatId($candidatId) {
        return $this->getRepository()->findOneBy(array('candidatId' => $candidatId));
    }
}