<?php
/**
 * Created by PhpStorm.
 * User: Xavier
 * Date: 29/03/2016
 * Time: 13:17
 */

namespace CoreBundle\Services;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ControllerService extends Controller
{
    # Under here for Controller Core
    private $message;

    private $insert;

    private $entity;

    private $newEntity;

    private $formType;

    private $alertText;

    private $isArchived;

    /**
     * CandidatController constructor.
     */
    public function __construct()
    {
        $path = Request::createFromGlobals()->getPathInfo();
        if ($path == '/admin/candidats')
        {
            $this->isArchived = '0';
        }
        if ($path == '/admin/candidats/archived')
        {
            $this->isArchived = '1';
        }
    }
    /**
     * @param $item
     * @param string $entity
     * @return mixed
     */
    private function generateMessage($item, $entity)
    {
        $this->message = $this->getParameter(strtolower($entity).'_insert_exceptions');
        return $this->message = $this->message[$item];
    }

    /**
     * @return array
     */
    private function generateListeChoices()
    {
        $listeChoices = [];
        $listeChoices['listeFonctions'] = $this->get("core.fonction_manager")->createList();
        $listeChoices['listeAgences'] = $this->get("core.agence_manager")->createList();
        $listeChoices['listeServices'] = $this->get("core.service_manager")->createList();

        return $listeChoices;
    }

    /**
     * @return \Symfony\Component\Form\Form
     */
    private function generateAddForm()
    {
        if ($this->entity == 'Candidat')
        {
            return $this->createForm($this->formType, new $this->newEntity, array('allow_extra_fields' => $this->generateListeChoices()));
        } else
        {
            return $this->createForm($this->formType, new $this->newEntity);
        }
    }

    /**
     * @param string $entity
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function getFullList($entity, $isArchived)
    {
        if ($this->entity == 'Candidat')
        {
            $allItems = $this->get('core.'.strtolower($entity).'_manager')->getRepository()->findByIsArchived($isArchived);
        } else
        {
            $allItems = $this->get('core.'.strtolower($entity).'_manager')->getRepository()->findAll();
        }
        return $this->render('CoreBundle:'.$entity.':view.html.twig', array(
            'all' => $allItems,
            'route' => $this->generateUrl('add_'.strtolower($entity)),
            'message' => $this->message,
            'code_message' => (int)$this->insert,
            'edit_path'=> 'edit_'.strtolower($entity),
            'remove_path' => 'remove_'.strtolower($entity),
            'alert_text' => $this->alertText,
            'is_archived' => $isArchived,
        ));
    }

    /**
     * @param \Symfony\Component\Form\FormView $form
     * @param $message
     * @param integer $insert
     * @param string $entity
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function generateRender($form, $message, $insert, $entity)
    {
        return $this->render('CoreBundle:'.$entity.':body.html.twig', array(
            'itemForm' => $form,
            'message' => $message,
            'code_message' => $insert,
        ));
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
    public function createTicket($nom,$prenom,$entite,$due_at,$agenceZendesk,$serviceZendesk,$fonctionZendesk,$statusPoste,$requester_email)
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
            'organizationIdId'=>$this->get('company.parameters_calls')->getParam('zendesk_field_organizationIdId'),
            'ticketFormIdId'=>$this->get('company.parameters_calls')->getParam('zendesk_field_ticketFormIdId'),
            'planifDateId'=>$this->get('company.parameters_calls')->getParam('zendesk_field_planifDateId'),
            'agenceId'=>$this->get('company.parameters_calls')->getParam('zendesk_field_agenceId'),
            'servicesId'=>$this->get('company.parameters_calls')->getParam('zendesk_field_servicesId'),
            'typeId'=>$this->get('company.parameters_calls')->getParam('zendesk_field_typeId'),
            'mainCatId'=>$this->get('company.parameters_calls')->getParam('zendesk_field_mainCatId'),
            'lowCatId'=>$this->get('company.parameters_calls')->getParam('zendesk_field_lowCatId'),
            'sendMatId'=>$this->get('company.parameters_calls')->getParam('zendesk_field_sendMatId'),
        );

        $json = $this->get('curl.create_ticket')->createJasonTicket($message_array,$due_at,$requester_email,$agenceZendesk,$serviceZendesk,$parametersTicket);

        return $this->get('curl.curl_wrap')->curlWrapExec("/tickets.json", $json);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function generateIndexAction()
    {
        if ($this->entity == 'Candidat')
        {
            return $this->getFullList($this->entity, $this->isArchived);
        } else
        {
            return $this->getFullList($this->entity, NULL);
        }
    }

    /**
     * @param $request
     * @param $entity
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function generateDeleteAction($request, $entity)
    {
        $itemToTemove = (int)$request->get('itemDelete');
        if ($this->entity == 'Candidat')
        {
            $remove = $this->get('core.'.strtolower($entity).'_manager')->removeCandidat($itemToTemove);
        } else
        {
            $remove = $this->get('core.'.strtolower($entity).'_manager')->remove($itemToTemove);
        }
        $this->message = $this->generateMessage($remove, $this->entity);
        $this->insert = $remove;

        if ($this->entity == 'Candidat')
        {
            return $this->getFullList($this->entity, $this->isArchived);
        } else
        {
            return $this->getFullList($this->entity, NULL);
        }
    }

    /**
     * @param $request
     * @param $entity
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function generateAddAction($request, $entity)
    {
        $form = $this->generateAddForm();
        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            if ($form->isValid()) {
                $this->insert = $this->get('core.'.strtolower($entity).'_manager')->add($request->get(strtolower($entity)));
//                private function initDataZendesk()
//                {
//                    $this->get('core.zendesk_service')->setNom('');
//                    $this->get('core.zendesk_service')->setPrenom('');
//                    $this->get('core.zendesk_service')->setEntite('Fonction');
//                    $this->get('core.zendesk_service')->setAgenceZendesk(Fonction::class);
//                    $this->get('core.zendesk_service')->setServiceZendesk('cette fonction');
//                    $this->get('core.zendesk_service')->setFonctionZendesk(FonctionType::class);
//                    $this->get('core.zendesk_service')->setStatusPoste('cette fonction');
//                    $this->get('core.zendesk_service')->setRequesterEmail('cette fonction');
//                }
//
//                $this->get('core.zendesk_service')->createTicket($request->get('candidat')['name'],$request->get('candidat')['surname'],'AramisAuto',$request->get('candidat')['startDate'],'Lyon','service','Conseiller Commercial','Création','xavier.arroues@aramisauto.com');
                $this->message = $this->generateMessage($this->insert, $this->entity);
                if ($this->insert != 1)
                {
                    $form = $this->generateAddForm();
                }
            }
            if (isset($request->get(strtolower($entity))['Envoyer'])) {
                if ($this->entity == 'Candidat')
                {
                    return $this->getFullList($this->entity, $this->isArchived);
                }
                else {
                    return $this->getFullList($this->entity, NULL);
                }
            }
        }
        return $this->generateRender($form->createView(), $this->message, (int)$this->insert, $this->entity);
    }

    /**
     * @param $request
     * @param $entity
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function generateEditAction($request, $entity)
    {
        $itemToEdit = (int)$request->get('itemEdit');
        $item = $this->get('core.'.strtolower($entity).'_manager')->getRepository()->findOneById($itemToEdit);
        $form = $this->createForm($this->formType, $item);
        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            if ($form->isValid()) {
                $edit = $this->get('core.'.strtolower($entity).'_manager')->edit($itemToEdit, $request->get(strtolower($entity)));
                $this->generateMessage($edit, $this->entity);
                $this->insert = $edit;
            }
            if (isset($request->get(strtolower($entity))['Envoyer'])) {
                if ($this->entity == 'Candidat')
                {
                    return $this->getFullList($this->entity, $this->isArchived);
                } else
                {
                    return $this->getFullList($this->entity, NULL);
                }
            }
        }
        return $this->generateRender($form->createView(), $this->message, (int)$this->insert, $this->entity);
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     * @return ControllerService
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getInsert()
    {
        return $this->insert;
    }

    /**
     * @param mixed $insert
     * @return ControllerService
     */
    public function setInsert($insert)
    {
        $this->insert = $insert;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param mixed $entity
     * @return ControllerService
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNewEntity()
    {
        return $this->newEntity;
    }

    /**
     * @param mixed $newEntity
     * @return ControllerService
     */
    public function setNewEntity($newEntity)
    {
        $this->newEntity = $newEntity;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFormType()
    {
        return $this->formType;
    }

    /**
     * @param mixed $formType
     * @return ControllerService
     */
    public function setFormType($formType)
    {
        $this->formType = $formType;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAlertText()
    {
        return $this->alertText;
    }

    /**
     * @param mixed $alertText
     * @return ControllerService
     */
    public function setAlertText($alertText)
    {
        $this->alertText = $alertText;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIsArchived()
    {
        return $this->isArchived;
    }

    /**
     * @param mixed $isArchived
     * @return ControllerService
     */
    public function setIsArchived($isArchived)
    {
        $this->isArchived = $isArchived;
        return $this;
    }
}