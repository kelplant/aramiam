<?php
namespace CoreBundle\Services;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class ZendeskService
 * @package CoreBundle\Services
 */
class ZendeskService extends Controller
{
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
    private function generateCustomFieldArray($parametersTicket,$due_at,$agence,$service,$new_station)
    {
        return array(
            array(
                'id'=>$parametersTicket['planifDateId'], 'value'=>date("Y-m-d",strtotime($due_at))),
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
    private function generateMessageArray($nom,$prenom,$entite,$due_at,$agenceZendesk,$serviceZendesk,$fonctionZendesk,$statusPoste)
    {
        return array(
            'nom' => $nom,
            'prenom' => $prenom,
            'entite' => $entite,
            'due_at' => $due_at,
            'agence' => $agenceZendesk,
            'service' => $serviceZendesk,
            'fonction' => $fonctionZendesk,
            'status_poste' => $statusPoste,
        );
    }

    /**
     * @return array
     */
    private function generateParametersArray()
    {
        return array(
            'organizationIdId' => $this->get('core.parameters_calls')->getParam('zendesk_field_organizationIdId'),
            'ticketFormIdId' => $this->get('core.parameters_calls')->getParam('zendesk_field_ticketFormIdId'),
            'planifDateId' => $this->get('core.parameters_calls')->getParam('zendesk_field_planifDateId'),
            'agenceId' => $this->get('core.parameters_calls')->getParam('zendesk_field_agenceId'),
            'servicesId' => $this->get('core.parameters_calls')->getParam('zendesk_field_servicesId'),
            'typeId' => $this->get('core.parameters_calls')->getParam('zendesk_field_typeId'),
            'mainCatId' => $this->get('core.parameters_calls')->getParam('zendesk_field_mainCatId'),
            'lowCatId' => $this->get('core.parameters_calls')->getParam('zendesk_field_lowCatId'),
            'sendMatId' => $this->get('core.parameters_calls')->getParam('zendesk_field_sendMatId'),
        );
    }

    /**
     * @param $message_array
     * @param $due_at
     * @param $requester_email
     * @param $agence
     * @param $service_zendesk
     * @param $parametersTicket
     * @return string
     */
    private function createJasonTicket($message_array,$due_at,$requester_email,$agence,$service_zendesk,$parametersTicket){

        $subject = "Un nouveau candidat a été ajouté";
        $service ="";
        $new_station = "false";
        if ($message_array['status_poste'] == "Création") {
            $new_station = "true";
        }
        if ($agence == "siège" && isset($service_zendesk)) {
            $service = $service_zendesk;
        }
        if (date("Y-m-d") < date("Y-m-d",strtotime($due_at))) {
            $status = 'hold';
        } else {
            $status = 'open';
        }

        return json_encode(array('ticket' => array(
            'subject' => $subject,
            'status' => $status,
            'comment' => array('body' => $this->generateBody($message_array)),
            'requester' => array('email' => $requester_email),
            'organization_id' =>  $parametersTicket['organizationIdId'],
            'ticket_form_id' => $parametersTicket['ticketFormIdId'],
            'priority' => "high",
            'custom_fields' => $this->generateCustomFieldArray($parametersTicket,$due_at,$agence,$service,$new_station),
        )));
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
     * @param $requester_email
     * @return mixed
     */
    public function createTicket($nom, $prenom, $entite, $due_at, $agenceZendesk, $serviceZendesk, $fonctionZendesk, $statusPoste, $requester_email)
    {

        define("ZDAPIKEY", $this->getParameter('zendesk_api_key')); # Alimenter parameter.yml
        define("ZDUSER", $this->getParameter('zendesk_api_user')); # Alimenter parameter.yml
        define("ZDURL", $this->getParameter('zendesk_api_url')); # Alimenter parameter.yml

        return $this->get('core.curl_wrap')->curlWrapExec("/tickets.json", $this->createJasonTicket($this->generateMessageArray($nom,$prenom,$entite,$due_at,$agenceZendesk,$serviceZendesk,$fonctionZendesk,$statusPoste), $due_at, $requester_email, $agenceZendesk, $serviceZendesk, $this->generateParametersArray()));
    }
}