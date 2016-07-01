<?php
namespace CoreBundle\Services\Manager;

use AppBundle\Services\Manager\AbstractManager;


/**
 * Class UtilisateurLogActionManager
 * @package CoreBundle\Services\Manager
 */
class UtilisateurLogActionManager extends AbstractManager
{
    public function getHistoryforUtilisateur($utilisateurId)
    {
        $historyforUser = [];
        foreach ($this->getRepository()->findBy(array('utilisateurId' => $utilisateurId), array('timestamp' => 'DESC')) as $historyItem) {
            $historyforUser[] = [
                'requesterId' => $historyItem->getRequesterId(),
                'utilisateurId' => $historyItem->getUtilisateurId(),
                'date' => $historyItem->getTimestamp()->format('d-m-Y'),
                'time' => $historyItem->getTimestamp()->format('H:m'),
                'field' => $historyItem->getField(),
                'oldString' => $historyItem->getOldString(),
                'newString' => $historyItem->getNewString(),
            ];
        }
        return $historyforUser;
    }
}