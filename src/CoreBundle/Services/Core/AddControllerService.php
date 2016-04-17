<?php
namespace CoreBundle\Services\Core;

use Symfony\Component\HttpFoundation\Request;
use CoreBundle\Entity\Admin\Candidat;
use CoreBundle\Entity\Admin\Fonction;
use CoreBundle\Form\Admin\FonctionType;
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
        return $this->get('core.zendesk_service')->createTicket(
            $candidat->getId(), $candidat->getName(), $candidat->getSurname(), $candidat->getEntiteHolding(), $candidat->getStartDate()->format("Y-m-d"),
            $this->getConvertion('agence', $candidat->getAgence())->getNameInZendesk(), $this->getConvertion('service', $candidat->getService())->getNameInZendesk(),
            $this->getConvertion('fonction', $candidat->getFonction())->getNameInZendesk(), $candidat->getStatusPoste(), 'xavier.arroues@aramisauto.com', $paramsZendeskApi
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
        var_dump($this->formAdd->isSubmitted());
        var_dump($this->formAdd->isValid());
        die();
        if ($this->formAdd->isSubmitted() && $this->formAdd->isValid()) {
            $return = $this->checkErrorCode($this->get('core.' . strtolower($this->entity) . '_manager')->add($request->request->get(strtolower($this->checkFormEntity($this->entity)))));
            $this->insert = $return['errorCode'];
            $this->message = $return['error'];
            if ($this->entity == 'Candidat') {
                $this->executeCreateTicket($return['item'], $this->getParameter('zendesk_api'));
            }
        }
        return $this->get('core.index.controller_service')->getFullList($this->isArchived, $this->formAdd, $this->formEdit);
    }
}