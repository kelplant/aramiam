<?php
namespace CoreBundle\Services\Core;

use Symfony\Component\HttpFoundation\Request;
use CoreBundle\Entity\Admin\Candidat;

/**
 * Class AddControllerService
 * @package CoreBundle\Services\Core
 */
class AddControllerService extends AbstractControllerService
{
    /**
     * @param Candidat $candidat
     * @return mixed
     */
    public function executeCreateTicket(Candidat $candidat, $paramsZendeskApi)
    {
        return $this->get('zendesk.zendesk_service')->createTicket(
            $candidat->getId(), $candidat->getName(), $candidat->getSurname(), $candidat->getEntiteHolding(), $candidat->getStartDate()->format("Y-m-d"),
            $this->getConvertion('agence', $candidat->getAgence())->getNameInZendesk(), $this->getConvertion('service', $candidat->getService())->getNameInZendesk(),
            $this->getConvertion('fonction', $candidat->getFonction())->getNameInZendesk(), $candidat->getStatusPoste(), $this->get('security.token_storage')->getToken()->getUser()->getEmail(),
            $paramsZendeskApi
        );
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function executeRequestAddAction(Request $request)
    {
        $this->initBothForms();
        $this->formAdd->handleRequest($request);
        if ($this->formAdd->isSubmitted() && $this->formAdd->isValid()) {

            $return = $this->get($this->servicePrefix.'.'.strtolower($this->entity).'_manager')->add($request->request->get(strtolower($this->checkFormEntity($this->entity))));
            if ($this->entity == 'Candidat') {
                $this->executeCreateTicket($return['item'], $this->getParameter('zendesk_api'));
                $this->get('core.candidat_recruteur_link_manager')->add(array('candidatId' => $return['item']->getId(), 'adminId' => $this->get('security.token_storage')->getToken()->getUser()->getId()));
            }
        }
        return $this->get('core.index.controller_service')->getFullList($this->isArchived, $this->formAdd, $this->formEdit);
    }
}