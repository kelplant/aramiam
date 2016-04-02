<?php
/**
 * Created by PhpStorm.
 * User: Xavier
 * Date: 29/03/2016
 * Time: 13:17
 */

namespace CoreBundle\Services;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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

    private $createFormArguments;

    private $remove;

    private $formItem;

    /**
     * @param $item
     * @return mixed
     */
    private function generateMessage($item)
    {
        $this->message = $this->getParameter(strtolower($this->entity).'_insert_exceptions');
        return $this->message = $this->message[$item];
    }

    /**
     * @return \Symfony\Component\Form\Form
     */
    private function generateForm()
    {
        return $this->createForm($this->formType, new $this->newEntity, $this->createFormArguments);
    }

    /**
     * @param $isArchived
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function getFullList($isArchived)
    {

        $formAdd = $this->generateForm();
        $formEdit = $this->generateForm();
        $allItems = $this->get('core.'.strtolower($this->entity).'_manager')->getRepository()->findAll();
        if ($this->entity == 'Candidat')
        {
            $i = 0;
            foreach ($allItems as $item) {
                $item->setStartDate($item->getStartDate()->format('d-m-Y'));
                $item->setAgence($this->get('core.agence_manager')->getRepository()->findOneById($item->getAgence())->getName());
                $item->setFonction($this->get('core.fonction_manager')->getRepository()->findOneById($item->getFonction())->getName());
                $item->setService($this->get('core.service_manager')->getRepository()->findOneById($item->getService())->getName());
                if ($item->getIsArchived() == 1)
                {
                    unset($allItems[$i]);
                }
                $i++;
            }
        }

        return $this->render('CoreBundle:'.$this->entity.':view.html.twig', array(
            'all' => $allItems,
            'route' => $this->generateUrl('form_exec_'.strtolower($this->entity)),
            'message' => $this->message,
            'code_message' => (int)$this->insert,
            'edit_path'=> 'edit_'.strtolower($this->entity),
            'remove_path' => 'remove_'.strtolower($this->entity),
            'alert_text' => $this->alertText,
            'is_archived' => $isArchived,
            'formAdd' => $formAdd->createView(),
            'formEdit' => $formEdit->createView(),
        ));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function generateIndexAction()
    {
        return $this->getFullList($this->isArchived);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function generateDeleteAction()
    {
        $this->message = $this->generateMessage($this->remove);
        $this->insert = $this->remove;

        return $this->getFullList($this->isArchived);
    }

    /**
     * @param $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function executeRequestAction($request)
    {
        if ($request->request->get('formAction') == 'add')
        {
            $this->insert = $this->get('core.'.strtolower($this->entity).'_manager')->add($request->request->get(strtolower($this->entity)));
            $this->message = $this->generateMessage($this->insert);
            $this->get('core.zendesk_service')->createTicket(
                $request->get('candidat')['name'],$request->get('candidat')['surname'],'AramisAuto',date("Y-m-d", strtotime($request->get('candidat')['startDate'])),
                $this->get('core.agence_manager')->getRepository()->findOneById($request->get('candidat')['agence'])->getName(),
                $this->get('core.service_manager')->getRepository()->findOneById($request->get('candidat')['service'])->getName(),
                $this->get('core.fonction_manager')->getRepository()->findOneById($request->get('candidat')['fonction'])->getName(),
                $request->get('candidat')['statusPoste'],'xavier.arroues@aramisauto.com'
            );
        }

        if ($request->request->get('formAction') == 'edit')
        {
            $this->insert = $this->get('core.'.strtolower($this->entity).'_manager')->edit($request->request->get(strtolower($this->entity))['id'], $request->request->get(strtolower($this->entity)));
            $this->message = $this->generateMessage($this->insert);
        }

        return $this->getFullList($this->isArchived);
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

    /**
     * @return mixed
     */
    public function getCreateFormArguments()
    {
        return $this->createFormArguments;
    }

    /**
     * @param mixed $createFormArguments
     * @return ControllerService
     */
    public function setCreateFormArguments($createFormArguments)
    {
        $this->createFormArguments = $createFormArguments;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRemove()
    {
        return $this->remove;
    }

    /**
     * @param mixed $remove
     * @return ControllerService
     */
    public function setRemove($remove)
    {
        $this->remove = $remove;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFormItem()
    {
        return $this->formItem;
    }

    /**
     * @param mixed $formItem
     * @return ControllerService
     */
    public function setFormItem($formItem)
    {
        $this->formItem = $formItem;
        return $this;
    }
}