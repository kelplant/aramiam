<?php
namespace CoreBundle\Services\Core;

use Symfony\Component\HttpFoundation\Request;

 class IndexControllerService extends AbstractControllerService
{
    /**
     * @param $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function executeRequestAddAction(Request $request)
    {
        $return = $this->checkErrorCode($this->get('core.'.strtolower($this->entity).'_manager')->add($request->request->get(strtolower($this->checkFormEntity($this->entity)))));
        $this->insert = $return['errorCode'];
        $this->message = $return['error'];
        if ($this->entity == 'Candidat') {
            $this->executeCreateTicket($return['candidat']);
        }
        return $this->getFullList($this->isArchived);
    }
}