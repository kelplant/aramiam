<?php
/**
 * Created by PhpStorm.
 * User: Xavier
 * Date: 29/03/2016
 * Time: 13:17
 */

namespace ZendeskBundle\Services;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ZendeskService extends Controller
{
    /**
     * @param $message_array
     * @return string
     */
    private function generateBody($message_array) {

        $body = "-------- Nouveau Candidat --------
                Prénom : ".$message_array['nom']."
                Nom : ".$message_array['prenom']."
                Entité : ".$message_array['entite']."

                Le candidat arrivera le ".$message_array['due_at']."

                Agence : ".$message_array['agence']."
                Service : ".$message_array['service']."

                Au poste de : ".$message_array['fonction']."

                Status du poste : ".$message_array['status_poste']
        ;

        return $body;
    }

    /**
     * @param $message_array
     * @param $due_at
     * @param $requester_email
     * @param $agence_zendesk
     * @param $service_zendesk
     * @param $parametersTicket
     * @return string
     */
    private function createJasonTicket($message_array,$due_at,$requester_email,$agence_zendesk,$service_zendesk,$parametersTicket){

        $subject = "Un nouveau candidat a été ajouté"; # Titre du mail
        $service ="";
        $status ="";
        $agence = $agence_zendesk;
        $new_station = "false"; # Par défault poste en remplacement pas de matériel à envoyer
        if ($message_array['status_poste'] == "Création") { # Attention ici à mettre à jour si on envoie pas création et remplacement passe à true matériel à envoyer
            $new_station = "true";
        }
        if ($agence == "siège" && isset($service_zendesk)) {
            $service = $service_zendesk;
        }
        $today = date("Y-m-d");
        if ($today != $due_at) { # Vérification de la date si différente d'aujourd'hui ticket en pause
            $status = 'hold';
        }
        if ($today == $due_at) { # Vérification de la date celle d'aujourd'hui ticket ouvert
            $status = 'open';
        }
        $body = $this->generateBody($message_array); # On génère le body du Ticket avec les élements (accepte un tableau)
        $payload = array('ticket' => array(
            'subject' => $subject,
            'status' => $status,
            'comment' => array('body' => $body),
            'requester'=> array('email'=> $requester_email),
            'organization_id'=>  $parametersTicket['organizationIdId'],
            'ticket_form_id'=> $parametersTicket['ticketFormIdId'],
            'priority'=> "high",
            'custom_fields'=> array(
                array(
                    'id'=>$parametersTicket['planifDateId'], 'value'=>$due_at),
                array(
                    'id'=>$parametersTicket['agenceId'], 'value'=>$agence),
                array(
                    'id'=>$parametersTicket['servicesId'], 'value'=>$service),
                array(
                    'id'=>$parametersTicket['typeId'], 'value'=>"Demandes"),
                array(
                    'id'=>$parametersTicket['mainCatId'], 'value'=>"gestion_du_personnel"),
                array(
                    'id'=>$parametersTicket['lowCatId'], 'value'=>"arrivée_collaborateur"),
                array(
                    'id'=>$parametersTicket['sendMatId'], 'value'=>$new_station),
            )
        ));

        $json = json_encode($payload);
        return $json;
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
        $message_array = array(
            'nom'=>$nom,
            'prenom'=>$prenom,
            'entite'=>$entite,
            'due_at' =>$due_at,
            'agence' =>$agenceZendesk,
            'service' =>$serviceZendesk,
            'fonction' =>$fonctionZendesk,
            'status_poste' =>$statusPoste,
        );

        define("ZDAPIKEY", $this->getParameter('zendesk_api_key')); # Alimenter parameter.yml
        define("ZDUSER", $this->getParameter('zendesk_api_user')); # Alimenter parameter.yml
        define("ZDURL", $this->getParameter('zendesk_api_url')); # Alimenter parameter.yml

        $parametersTicket = array(
            'organizationIdId'=>$this->get('core.parameters_calls')->getParam('zendesk_field_organizationIdId'),
            'ticketFormIdId'=>$this->get('core.parameters_calls')->getParam('zendesk_field_ticketFormIdId'),
            'planifDateId'=>$this->get('core.parameters_calls')->getParam('zendesk_field_planifDateId'),
            'agenceId'=>$this->get('core.parameters_calls')->getParam('zendesk_field_agenceId'),
            'servicesId'=>$this->get('core.parameters_calls')->getParam('zendesk_field_servicesId'),
            'typeId'=>$this->get('core.parameters_calls')->getParam('zendesk_field_typeId'),
            'mainCatId'=>$this->get('core.parameters_calls')->getParam('zendesk_field_mainCatId'),
            'lowCatId'=>$this->get('core.parameters_calls')->getParam('zendesk_field_lowCatId'),
            'sendMatId'=>$this->get('core.parameters_calls')->getParam('zendesk_field_sendMatId'),
        );

        $json = $this->createJasonTicket($message_array, $due_at, $requester_email, $agenceZendesk, $serviceZendesk, $parametersTicket);

        return $this->get('core.curl_wrap')->curlWrapExec("/tickets.json", $json);
    }
}