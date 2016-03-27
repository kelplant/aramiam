<?php

namespace CoreBundle\Controller;

use CoreBundle\Form\CandidatType;
use CoreBundle\Entity\Candidat;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CandidatController extends Controller
{
    private $message;

    private $insert;

    private $request;

    private $candidatLoad;

    /**
     * CandidatController constructor.
     */
    public function __construct()
    {
        $this->message = "";
        $this->insert = "";
        $this->request = Request::createFromGlobals()->getPathInfo();
        $this->candidatLoad = Request::createFromGlobals()->request->get('candidat');
    }

    /**
     * @param $item
     * @return mixed
     */
    private function generateMessage($item)
    {
        $this->message = $this->getParameter('candidat_insert_exceptions');
        return $this->message = $this->message[$item];
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function getFullList()
    {
        $allCandidats = $this->get('core.candidat_manager')->getRepository()->findAll();
        return $this->render('CoreBundle:Candidat:view.html.twig', array(
            'all' => $allCandidats,
            'route' => $this->generateUrl('add_candidat'),
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
        return $this->render('CoreBundle:Candidat:body.html.twig', array(
            'candidatForm' => $form,
            'message' => $message,
            'code_message' => $insert,
        ));
    }

    /**
     * @param $object
     * @param $candidat
     * @param $action
     * @return \Symfony\Component\Form\Form
     */
    private function generateForm($object,$candidat,$action)
    {
        return $this->createForm($object,$candidat, array(
            'action' => $action,
            'method' => 'POST',
        ));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $routeName = substr($this->request,0,23);

        if($routeName == '/admin/candidats/delete')
        {
            $candidatToTemove = (int)substr($this->request,24);
            $remove = $this->get('core.candidat_manager')->removeCandidat($candidatToTemove);
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
        $candidat = new Candidat();

        $form = $this->generateForm(new CandidatType('Envoyer', 'Envoyer et Nouveau'),$candidat,$this->generateUrl('add_candidat'));

        if (isset($this->candidatLoad['Envoyer']) OR isset($this->candidatLoad['EnvoyerNouveau'])) {
            $this->insert = $this->get('core.candidat_manager')->setCandidat($this->candidatLoad);
            $this->message = $this->generateMessage($this->insert);
        }

        if (isset($this->candidatLoad['Envoyer'])) {
            return $this->getFullList();
        }

        return $this->generateRender($form->createView(),$this->message,(int)$this->insert);
    }

    /**
     * @param $candidatEdit
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction($candidatEdit)
    {
        if (isset($this->candidatLoad['Envoyer']) OR isset($this->candidatLoad['EnvoyerNouveau'])) {
            $edit = $this->get('core.candidat_manager')->editCandidat($candidatEdit,$this->candidatLoad);
            $this->generateMessage($edit);
            $this->insert = $edit;
        }
        if (isset($this->candidatLoad['Envoyer'])) {
            return $this->getFullList();
        }
        $candidat = $this->get("core.candidat_manager")->getRepository()->findOneById($candidatEdit);
        $form = $this->generateForm(new CandidatType('Mettre & Jour', 'MàJ et Rester'),$candidat,$this->generateUrl('edit_candidat', array('candidatEdit' => $candidatEdit)));

        return $this->generateRender($form->createView(),$this->message,(int)$this->insert);
    }
}