<?php

namespace CoreBundle\Controller;

use CoreBundle\Form\AgenceType;
use CoreBundle\Entity\Agence;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AgenceController extends Controller
{
    private $message;

    private $insert;

    private $request;

    private $agenceLoad;

    /**
     * AgenceController constructor.
     */
    public function __construct()
    {
        $this->message = "";
        $this->insert = "";
        $this->request = Request::createFromGlobals()->getPathInfo();
        $this->agenceLoad = Request::createFromGlobals()->request->get('agence');
    }

    /**
     * @param $item
     * @return mixed
     */
    private function generateMessage($item)
    {
        $this->message = $this->getParameter('agence_insert_exceptions');
        return $this->message = $this->message[$item];
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function getFullList()
    {
        $allAgences = $this->get('core.agence_manager')->getRepository()->findAll();
        return $this->render('CoreBundle:Agence:view.html.twig', array(
            'all' => $allAgences,
            'route' => $this->generateUrl('add_agence'),
            'message' => $this->message,
            'code_message' => (int)$this->insert,
        ));
    }

    /**
     * @param $form
     * @param $message
     * @param $insert
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function generateRender($form,$message,$insert)
    {
        return $this->render('CoreBundle:Agence:body.html.twig', array(
            'agenceForm' => $form,
            'message' => $message,
            'code_message' => $insert,
        ));
    }

    /**
     * @param $object
     * @param $agence
     * @param $action
     * @return \Symfony\Component\Form\Form
     */
    private function generateForm($object,$agence,$action)
    {
        return $this->createForm($object,$agence, array(
            'action' => $action,
            'method' => 'POST',
        ));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $routeName = substr($this->request,0,21);
        if($routeName == '/admin/agences/delete')
        {
            $agenceToTemove = (int)substr($this->request,22);
            $remove = $this->get('core.agence_manager')->removeAgence($agenceToTemove);
            $this->message = $this->generateMessage($remove);
            $this->insert = $remove;
        }

        return $this->getFullList();
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addAction()
    {
        $agence = new Agence();

        $form = $this->generateForm(new AgenceType('Envoyer', 'Envoyer et Nouveau'),$agence,$this->generateUrl('add_agence'));

        if (isset($this->agenceLoad['Envoyer']) OR isset($this->agenceLoad['EnvoyerNouveau'])) {
            $this->insert = $this->get('core.agence_manager')->setAgence($this->agenceLoad);
            $this->message = $this->generateMessage($this->insert);
        }

        if (isset($this->agenceLoad['Envoyer'])) {
            return $this->getFullList();
        }

        return $this->generateRender($form->createView(),$this->message,(int)$this->insert);
    }

    /**
     * @param $agenceEdit
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction($agenceEdit)
    {
        if (isset($this->agenceLoad['Envoyer']) OR isset($this->agenceLoad['EnvoyerNouveau'])) {
            $edit = $this->get('core.agence_manager')->editAgence($agenceEdit,$this->agenceLoad);
            $this->generateMessage($edit);
            $this->insert = $edit;
        }
        if (isset($this->agenceLoad['Envoyer'])) {
            return $this->getFullList();
        }
        $agence = $this->get("core.agence_manager")->getRepository()->findOneById($agenceEdit);
        $form = $this->generateForm(new AgenceType('Mettre & Jour', 'MàJ et Rester'),$agence,$this->generateUrl('edit_agence', array('agenceEdit' => $agenceEdit)));

        return $this->generateRender($form->createView(),$this->message,(int)$this->insert);
    }
}