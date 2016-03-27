<?php

namespace CoreBundle\Controller;

use CoreBundle\Form\FonctionType;
use CoreBundle\Entity\Fonction;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FonctionController extends Controller
{
    private $message;

    private $insert;

    private $request;

    private $fonctionLoad;

    /**
     * FonctionController constructor.
     */
    public function __construct()
    {
        $this->message = "";
        $this->insert = "";
        $this->request = Request::createFromGlobals()->getPathInfo();
        $this->fonctionLoad = Request::createFromGlobals()->request->get('fonction');
    }

    /**
     * @param $item
     * @return mixed
     */
    private function generateMessage($item)
    {
        $this->message = $this->getParameter('fonction_insert_exceptions');
        return $this->message = $this->message[$item];
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function getFullList()
    {
        $allFonctions = $this->get('core.fonction_manager')->getRepository()->findAll();
        return $this->render('CoreBundle:Fonction:view.html.twig', array(
            'all' => $allFonctions,
            'route' => $this->generateUrl('add_fonction'),
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
    private function generateRender($form, $message, $insert)
    {
        return $this->render('CoreBundle:Fonction:body.html.twig', array(
            'fonctionForm' => $form,
            'message' => $message,
            'code_message' => $insert,
        ));
    }

    /**
     * @param $object
     * @param $fonction
     * @param $action
     * @return \Symfony\Component\Form\Form
     */
    private function generateForm($object, $fonction, $action)
    {
        return $this->createForm($object, $fonction, array(
            'action' => $action,
            'method' => 'POST',
        ));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $routeName = substr($this->request, 0, 23);

        if ($routeName == '/admin/fonctions/delete')
        {
            $fonctionToTemove = (int)substr($this->request, 24);
            $remove = $this->get('core.fonction_manager')->removeFonction($fonctionToTemove);
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
        $fonction = new Fonction();

        $form = $this->generateForm(new FonctionType('Envoyer', 'Envoyer et Nouveau'), $fonction, $this->generateUrl('add_fonction'));

        if (isset($this->fonctionLoad['Envoyer']) OR isset($this->fonctionLoad['EnvoyerNouveau'])) {
            $this->insert = $this->get('core.fonction_manager')->setFonction($this->fonctionLoad);
            $this->message = $this->generateMessage($this->insert);
        }

        if (isset($this->fonctionLoad['Envoyer'])) {
            return $this->getFullList();
        }

        return $this->generateRender($form->createView(), $this->message, (int)$this->insert);
    }

    /**
     * @param $fonctionEdit
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction($fonctionEdit)
    {
        if (isset($this->fonctionLoad['Envoyer']) OR isset($this->fonctionLoad['EnvoyerNouveau'])) {
            $edit = $this->get('core.fonction_manager')->editFonction($fonctionEdit, $this->fonctionLoad);
            $this->generateMessage($edit);
            $this->insert = $edit;
        }
        if (isset($this->fonctionLoad['Envoyer'])) {
            return $this->getFullList();
        }
        $fonction = $this->get("core.fonction_manager")->getRepository()->findOneById($fonctionEdit);
        $form = $this->generateForm(new FonctionType('Mettre & Jour', 'MàJ et Rester'), $fonction, $this->generateUrl('edit_fonction', array('fonctionEdit' => $fonctionEdit)));

        return $this->generateRender($form->createView(), $this->message, (int)$this->insert);
    }
}