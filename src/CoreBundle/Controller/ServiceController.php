<?php

namespace CoreBundle\Controller;

use CoreBundle\Form\ServiceType;
use CoreBundle\Entity\Service;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ServiceController extends Controller
{
    private $message;

    private $insert;

    private $request;

    private $serviceLoad;

    /**
     * ServiceController constructor.
     */
    public function __construct()
    {
        $this->message = "";
        $this->insert = "";
        $this->request = Request::createFromGlobals()->getPathInfo();
        $this->serviceLoad = Request::createFromGlobals()->request->get('service');
    }

    /**
     * @param $item
     * @return mixed
     */
    private function generateMessage($item)
    {
        $this->message = $this->getParameter('service_insert_exceptions');
        return $this->message = $this->message[$item];
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function getFullList()
    {
        $allServices = $this->get('core.service_manager')->getRepository()->findAll();
        return $this->render('CoreBundle:Service:view.html.twig', array(
            'all' => $allServices,
            'route' => $this->generateUrl('add_service'),
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
        return $this->render('CoreBundle:Service:body.html.twig', array(
            'serviceForm' => $form,
            'message' => $message,
            'code_message' => $insert,
        ));
    }

    /**
     * @param $object
     * @param $service
     * @param $action
     * @return \Symfony\Component\Form\Form
     */
    private function generateForm($object, $service, $action)
    {
        return $this->createForm($object, $service, array(
            'action' => $action,
            'method' => 'POST',
        ));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $routeName = substr($this->request, 0, 22);
        if ($routeName == '/admin/services/delete')
        {
            $serviceToTemove = (int)substr($this->request, 23);
            $remove = $this->get('core.service_manager')->removeService($serviceToTemove);
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
        $service = new Service();

        $form = $this->generateForm(new ServiceType('Envoyer', 'Envoyer et Nouveau'), $service, $this->generateUrl('add_service'));

        if (isset($this->serviceLoad['Envoyer']) OR isset($this->serviceLoad['EnvoyerNouveau'])) {
            $this->insert = $this->get('core.service_manager')->setService($this->serviceLoad);
            $this->message = $this->generateMessage($this->insert);
        }

        if (isset($this->serviceLoad['Envoyer'])) {
            return $this->getFullList();
        }

        return $this->generateRender($form->createView(), $this->message, (int)$this->insert);
    }

    /**
     * @param $serviceEdit
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction($serviceEdit)
    {
        if (isset($this->serviceLoad['Envoyer']) OR isset($this->serviceLoad['EnvoyerNouveau'])) {
            $edit = $this->get('core.service_manager')->editService($serviceEdit, $this->serviceLoad);
            $this->generateMessage($edit);
            $this->insert = $edit;
        }
        if (isset($this->serviceLoad['Envoyer'])) {
            return $this->getFullList();
        }
        $service = $this->get("core.service_manager")->getRepository()->findOneById($serviceEdit);
        $form = $this->generateForm(new ServiceType('Mettre & Jour', 'MàJ et Rester'), $service, $this->generateUrl('edit_service', array('serviceEdit' => $serviceEdit)));

        return $this->generateRender($form->createView(), $this->message, (int)$this->insert);
    }
}
