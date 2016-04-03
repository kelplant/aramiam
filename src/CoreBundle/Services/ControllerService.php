<?php
namespace CoreBundle\Services;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ControllerService extends Controller
{
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
     * @param $manager
     * @param $what
     * @return mixed
     */
    private function getConvertion($manager,$what)
    {
        return $this->get('core.'.$manager.'_manager')->getRepository()->findOneById($what)->getName();
    }

    /**
     * @param $request
     * @return mixed
     */
    public function executeCreateTicket($request)
    {
        return $this->get('core.zendesk_service')->createTicket(
            $request->get('candidat')['name'],$request->get('candidat')['surname'],$request->get('candidat')['entiteHolding'],date("Y-m-d", strtotime($request->get('candidat')['startDate'])),
            $this->getConvertion('agence',$request->get('candidat')['agence']),$this->getConvertion('service',$request->get('candidat')['service']),
            $this->getConvertion('fonction',$request->get('candidat')['fonction']),$request->get('candidat')['statusPoste'],'xavier.arroues@aramisauto.com'
        );
    }

    /**
     * @param $isArchived
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getFullList($isArchived)
    {

        $formAdd = $this->generateForm();
        $formEdit = $this->generateForm();
        $allItems = $this->get('core.'.strtolower($this->entity).'_manager')->getRepository()->findAll();
        if ($this->entity == 'Candidat')
        {
            $i = 0;
            foreach ($allItems as $item) {
                $item->setStartDate($item->getStartDate()->format('d-m-Y'));
                $item->setAgence($this->getConvertion('agence',$item->getAgence()));
                $item->setFonction($this->getConvertion('fonction',$item->getFonction()));
                $item->setService($this->getConvertion('service',$item->getService()));
                if ($item->getIsArchived() == 1 && $this->isArchived == 0)
                {
                    unset($allItems[$i]);
                } elseif ($item->getIsArchived() == 0 && $this->isArchived == 1)
                {
                    unset($allItems[$i]);
                }
                $i++;
            }
        }

        return $this->render('CoreBundle:'.$this->entity.':view.html.twig', array(
            'all' => $allItems,
            'message' => $this->message,
            'code_message' => (int)$this->insert,
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
    public function executeRequestAddAction($request)
    {

        if ($request->request->get('formAction') == 'add')
        {
            $this->insert = $this->get('core.'.strtolower($this->entity).'_manager')->add($request->request->get(strtolower($this->entity)));
            $this->message = $this->generateMessage($this->insert);
            $this->executeCreateTicket($request);

        }
        return $this->getFullList($this->isArchived);
    }

    /**
     * @param $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function executeRequestEditAction($request)
    {
        if ($request->request->get('formAction') == 'edit')
        {
            $this->insert = $this->get('core.'.strtolower($this->entity).'_manager')->edit($request->request->get(strtolower($this->entity))['id'], $request->request->get(strtolower($this->entity)));
            $this->message = $this->generateMessage($this->insert);

            if($request->request->get('sendAction') == "Sauver et Transformer")
            {
                echo "transform salarié";
            }

        }
        return $this->getFullList($this->isArchived);
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
     * @param mixed $insert
     * @return ControllerService
     */
    public function setInsert($insert)
    {
        $this->insert = $insert;
        return $this;
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
     * @param mixed $newEntity
     * @return ControllerService
     */
    public function setNewEntity($newEntity)
    {
        $this->newEntity = $newEntity;
        return $this;
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
     * @param mixed $alertText
     * @return ControllerService
     */
    public function setAlertText($alertText)
    {
        $this->alertText = $alertText;
        return $this;
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
     * @param mixed $createFormArguments
     * @return ControllerService
     */
    public function setCreateFormArguments($createFormArguments)
    {
        $this->createFormArguments = $createFormArguments;
        return $this;
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
     * @param mixed $formItem
     * @return ControllerService
     */
    public function setFormItem($formItem)
    {
        $this->formItem = $formItem;
        return $this;
    }
}