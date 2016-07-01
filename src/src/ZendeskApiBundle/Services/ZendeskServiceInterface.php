<?php
namespace  ZendeskApiBundle\Services;

interface ZendeskServiceInterface
{
    public function createTicket($id, $nom, $prenom, $entite, $due_at, $agenceZendesk, $serviceZendesk, $fonctionZendesk, $statusPoste, $requester_email, $paramsZendeskApi);
    public function deleteTicket($ticketId, $paramsZendeskApi);
    public function updateStartDateTicket($ticketId, $newStartDate, $paramsZendeskApi);
}