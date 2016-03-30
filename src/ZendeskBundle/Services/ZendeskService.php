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
    private $nom;

    private $prenom;

    private $entite;

    private $due_at;

    private $agenceZendesk;

    private $serviceZendesk;

    private $fonctionZendesk;

    private $statusPoste;

    private $requester_email;

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

        $json = $this->get('zendesk.create_ticket')->createJasonTicket($message_array, $due_at, $requester_email, $agenceZendesk, $serviceZendesk, $parametersTicket);

        return $this->get('core.curl_wrap')->curlWrapExec("/tickets.json", $json);
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     * @return ZendeskService
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param mixed $prenom
     * @return ZendeskService
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEntite()
    {
        return $this->entite;
    }

    /**
     * @param mixed $entite
     * @return ZendeskService
     */
    public function setEntite($entite)
    {
        $this->entite = $entite;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDueAt()
    {
        return $this->due_at;
    }

    /**
     * @param mixed $due_at
     * @return ZendeskService
     */
    public function setDueAt($due_at)
    {
        $this->due_at = $due_at;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAgenceZendesk()
    {
        return $this->agenceZendesk;
    }

    /**
     * @param mixed $agenceZendesk
     * @return ZendeskService
     */
    public function setAgenceZendesk($agenceZendesk)
    {
        $this->agenceZendesk = $agenceZendesk;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getServiceZendesk()
    {
        return $this->serviceZendesk;
    }

    /**
     * @param mixed $serviceZendesk
     * @return ZendeskService
     */
    public function setServiceZendesk($serviceZendesk)
    {
        $this->serviceZendesk = $serviceZendesk;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFonctionZendesk()
    {
        return $this->fonctionZendesk;
    }

    /**
     * @param mixed $fonctionZendesk
     * @return ZendeskService
     */
    public function setFonctionZendesk($fonctionZendesk)
    {
        $this->fonctionZendesk = $fonctionZendesk;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatusPoste()
    {
        return $this->statusPoste;
    }

    /**
     * @param mixed $statusPoste
     * @return ZendeskService
     */
    public function setStatusPoste($statusPoste)
    {
        $this->statusPoste = $statusPoste;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRequesterEmail()
    {
        return $this->requester_email;
    }

    /**
     * @param mixed $requester_email
     * @return ZendeskService
     */
    public function setRequesterEmail($requester_email)
    {
        $this->requester_email = $requester_email;
        return $this;
    }

}