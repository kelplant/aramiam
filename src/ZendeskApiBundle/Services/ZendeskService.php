<?php
namespace ZendeskApiBundle\Services;

use ZendeskApiBundle\Services\Manager\ZendeskTicketLinkManager;
use CoreBundle\Services\Manager\ParametersManager;

/**
 * Class ZendeskService
 * @package ZendeskApiBundle\Services
 */
class ZendeskService
{
    protected $curlWrap;

    protected $zendeskTicketLinkManager;

    protected $parametersCalls;

    /**
     * ZendeskService constructor.
     * @param CurlWrap $curlWrap
     * @param ZendeskTicketLinkManager $zendeskTicketLinkManager
     * @param ParametersManager $parametersCalls
     */
    public function __construct($curlWrap, $zendeskTicketLinkManager, $parametersCalls)
    {
        $this->curlWrap = $curlWrap;
        $this->zendeskTicketLinkManager = $zendeskTicketLinkManager;
        $this->parametersCalls = $parametersCalls;
    }

    /**
     * @param $message_array
     * @return string
     */
    private function generateBody($message_array) {

        return  "-------- Nouveau Candidat --------
                Prénom : ".$message_array['nom']."
                Nom : ".$message_array['prenom']."
                Entité : ".$message_array['entite']."

                Le candidat arrivera le ".$message_array['due_at']."

                Agence : ".$message_array['agence']."
                Service : ".$message_array['service']."

                Au poste de : ".$message_array['fonction']."

                Status du poste : ".$message_array['status_poste']
        ;
    }

    /**
     * @param $parametersTicket
     * @param $due_at
     * @param $agence
     * @param $service
     * @param $new_station
     * @return array
     */
    private function generateCustomFieldArray($parametersTicket, $due_at, $agence, $service, $new_station)
    {
        return array(
            array(
                'id' => $parametersTicket['planifDateId'], 'value' => date("Y-m-d", strtotime($due_at))),
            array(
                'id' => $parametersTicket['agenceId'], 'value' => $agence),
            array(
                'id' => $parametersTicket['servicesId'], 'value' => $service),
            array(
                'id' => $parametersTicket['typeId'], 'value' => "Demandes"),
            array(
                'id' => $parametersTicket['mainCatId'], 'value' => "gestion_du_personnel"),
            array(
                'id' => $parametersTicket['lowCatId'], 'value' => "arrivée_collaborateur"),
            array(
                'id' => $parametersTicket['sendMatId'], 'value' => $new_station),
        );
    }

    /**
     * @param $nom
     * @param $prenom
     * @param $entite
     * @param $due_at
     * @param $agenceZendesk
     * @param $serviceZendesk
     * @param $fonctionZendesk
     * @param $statusPoste
     * @return array
     */
    private function generateMessageArray($nom, $prenom, $entite, $due_at, $agenceZendesk, $serviceZendesk, $fonctionZendesk, $statusPoste)
    {
        return array('nom' => $nom, 'prenom' => $prenom, 'entite' => $entite, 'due_at' => $due_at, 'agence' => $agenceZendesk, 'service' => $serviceZendesk, 'fonction' => $fonctionZendesk, 'status_poste' => $statusPoste);
    }

    /**
     * @return array
     */
    private function generateParametersArray()
    {
        return array('organizationIdId' => $this->parametersCalls->getParam('zendesk_field_organizationIdId'), 'ticketFormIdId' => $this->parametersCalls->getParam('zendesk_field_ticketFormIdId'), 'planifDateId' => $this->parametersCalls->getParam('zendesk_field_planifDateId'), 'agenceId' => $this->parametersCalls->getParam('zendesk_field_agenceId'), 'servicesId' => $this->parametersCalls->getParam('zendesk_field_servicesId'), 'typeId' => $this->parametersCalls->getParam('zendesk_field_typeId'), 'mainCatId' => $this->parametersCalls->getParam('zendesk_field_mainCatId'), 'lowCatId' => $this->parametersCalls->getParam('zendesk_field_lowCatId'), 'sendMatId' => $this->parametersCalls->getParam('zendesk_field_sendMatId'));
    }

    /**
     * @param $due_at
     * @return string
     */
    private function returnStatus($due_at)
    {
        if (date("Y-m-d") < date("Y-m-d", strtotime($due_at))) {
            return 'hold';
        } else {
            return 'open';
        }
    }

    /**
     * @param $StatusPoste
     * @return string
     */
    private function returnStatusPoste($StatusPoste)
    {

        if ($StatusPoste == "Création") {
            return "true";
        } else {
            return "false";
        }
    }

    /**
     * @param $agence
     * @param $service_zendesk
     * @return string
     */
    private function returnService($agence, $service_zendesk)
    {
        if ($agence == "siège" && isset($service_zendesk)) {
            return $service_zendesk;
        } else {
            return "";
        }

    }

    /**
     * @param $message_array
     * @param $due_at
     * @param $requester_email
     * @param $agence
     * @param $service_zendesk
     * @return string
     */
    private function createJsonTicket($message_array, $due_at, $requester_email, $agence, $service_zendesk)
    {
        $parametersTicket = $this->generateParametersArray();

        return json_encode(array('ticket' => array(
            'subject' => "Un nouveau candidat a été ajouté",
            'status' => $this->returnStatus($due_at),
            'comment' => array('body' => $this->generateBody($message_array)),
            'requester' => array('email' => $requester_email),
            'organization_id' =>  $parametersTicket['organizationIdId'],
            'ticket_form_id' => $parametersTicket['ticketFormIdId'],
            'priority' => "high",
            'custom_fields' => $this->generateCustomFieldArray($parametersTicket, $due_at, $agence, $this->returnService($agence, $service_zendesk), $this->returnStatusPoste($message_array['status_poste'])),
        )));
    }

    /**
     * @param $newStartDate
     * @return string
     */
    private function updateJsonTicket($newStartDate)
    {
        $status = $this->returnStatus($newStartDate);
        $parametersTicket = $this->generateParametersArray();
        return json_encode(array('ticket' => array(
            'status' => $status,
            'custom_fields' => array(
                array(
                    'id' => $parametersTicket['planifDateId'], 'value' => date("Y-m-d", strtotime($newStartDate))),
            )
        )));
    }

    /**
     * @param $id
     * @param $nom
     * @param $prenom
     * @param $entite
     * @param $due_at
     * @param $agenceZendesk
     * @param $serviceZendesk
     * @param $fonctionZendesk
     * @param $statusPoste
     * @param $requester_email
     * @param $paramsZendeskApi
     * @return mixed
     */
    public function createTicket($id, $nom, $prenom, $entite, $due_at, $agenceZendesk, $serviceZendesk, $fonctionZendesk, $statusPoste, $requester_email, $paramsZendeskApi)
    {
        $createdTicket = $this->curlWrap->curlWrap('/api/v2/tickets.json', $this->createJsonTicket($this->generateMessageArray($nom, $prenom, $entite, $due_at, $agenceZendesk, $serviceZendesk, $fonctionZendesk, $statusPoste), $due_at, $requester_email, $agenceZendesk, $serviceZendesk), $paramsZendeskApi, "POST");
        $this->zendeskTicketLinkManager->setParamForName($id, $createdTicket->ticket->id);
        return $createdTicket;
    }

    /**
     * @param $ticketId
     * @param $paramsZendeskApi
     * @return mixed
     */
    public function deleteTicket($ticketId, $paramsZendeskApi)
    {
        $this->zendeskTicketLinkManager->removeByTicketId($ticketId);
        return $this->curlWrap->curlWrap('/api/v2/tickets/'.$ticketId.'.json', null, $paramsZendeskApi, "DELETE");
    }

    /**
     * @param $ticketId
     * @param $newStartDate
     * @param $paramsZendeskApi
     */
    public function updateStartDateTicket($ticketId, $newStartDate, $paramsZendeskApi)
    {
        $this->curlWrap->curlWrap('/api/v2/tickets/'.$ticketId.'.json', $this->updateJsonTicket($newStartDate), $paramsZendeskApi, "PUT");
        return;
    }
}