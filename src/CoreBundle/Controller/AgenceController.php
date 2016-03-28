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

    private $entity;

    private $newEntity;

    private $formType;

    private $alertText;

    /**
     * AgenceController constructor.
     */
    public function __construct()
    {
        $this->message = "";
        $this->insert = "";
        $this->entity = "Agence";
        $this->newEntity = Agence::class;
        $this->formType = AgenceType::class;
        $this->alertText = 'cette agence';
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
     * @return \Symfony\Component\Form\Form
     */
    private function generateAddForm()
    {
        return $this->createForm($this->formType, new $this->newEntity);
    }

    /**
     * @param string $entity
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function getFullList($entity)
    {
        $allItems = $this->get('core.'.strtolower($entity).'_manager')->getRepository()->findAll();
        return $this->render('CoreBundle:'.$entity.':view.html.twig', array(
            'all' => $allItems,
            'route' => $this->generateUrl('add_'.strtolower($entity)),
            'message' => $this->message,
            'code_message' => (int)$this->insert,
            'edit_path'=> 'edit_'.strtolower($entity),
            'remove_path' => 'remove_'.strtolower($entity),
            'alert_text' => $this->alertText,
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
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function generateIndexAction()
    {
        return $this->getFullList($this->entity);
    }

    /**
     * @param Request $request
     * @param string $entity
     */
    public function generateDeleteAction($request,$entity)
    {
        $itemToTemove = (int)$request->get('itemDelete');
        $remove = $this->get('core.'.strtolower($entity).'_manager')->remove($itemToTemove);
        $this->message = $this->generateMessage($remove,$this->entity);
        $this->insert = $remove;
        return $this->getFullList($this->entity);
    }

    /**
     * @param Request $request
     * @param string $entity
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
                $this->message = $this->generateMessage($this->insert, $this->entity);
                if ($this->insert != 1) $form = $this->generateAddForm();
            }
            if (isset($request->get(strtolower($entity))['Envoyer'])) {
                return $this->getFullList($this->entity);
            }
        }
        return $this->generateRender($form->createView(), $this->message, (int)$this->insert, $this->entity);
    }

    /**
     * @param Request $request
     * @param string $entity
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
                return $this->getFullList($this->entity);
            }
        }
        return $this->generateRender($form->createView(), $this->message, (int)$this->insert, $this->entity);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->generateIndexAction();
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Request $request)
    {
        return $this->generateDeleteAction($request, $this->entity);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request)
    {
        return $this->generateAddAction($request, $this->entity);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request)
    {
        return $this->generateEditAction($request, $this->entity);
    }
}