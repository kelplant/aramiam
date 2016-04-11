<?php
namespace CoreBundle\Services;

use CoreBundle\Entity\Admin\Candidat;
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
     * @param $return
     * @return mixed
     */
    private function checkErrorCode($return)
    {
        if ($return['errorCode'] === true) {
            return array('errorCode' => $return['errorCode'], 'error' => $return['error'], 'candidat' => $return['candidat']);
        } elseif ($return['errorCode'] == 6669 || $return['errorCode'] == 6667) {
            return array('errorCode' => $return['errorCode'], 'error' => $this->generateMessage($return['errorCode']), 'candidat' => $return['candidat']);
        } else {
            return array('errorCode' => null, 'error' => null, 'candidat' => null);
        }
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
    private function getConvertion($manager, $what)
    {
        return $this->get('core.'.$manager.'_manager')->getRepository()->findOneById($what);
    }

    /**
     * @param $entity
     * @return mixed
     */
    private function checkFormEntity($entity)
    {
        $majInEntity = preg_match_all('/[A-Z]/', $entity, $matches, PREG_OFFSET_CAPTURE);
        if ($majInEntity >1) {
            for ($i=1;$i<=$majInEntity;$i++) {
                return str_replace($matches[0][$i][0],'_'.$matches[0][$i][0],$this->entity);
            }
        } else {
            return $entity;
        }
    }

    /**
     * @param $allItems
     * @param $item
     * @param $number
     * @param $i
     * @return mixed
     */
    private function filterView($allItems, $item, $number, $i)
    {
        if ($item->getIsArchived() != $number && $this->isArchived == $number) {
            unset($allItems[$i]);
        }
        return $allItems;
    }

    /**
     * @param $sendaction
     * @param $request
     * @return mixed|null
     */
    private function saveEditIfSaveOrTransform($sendaction, $request)
    {
        if ($sendaction == "Sauvegarder" || $sendaction == "Sauver et Transformer") {
            return  $this->get('core.'.strtolower($this->entity).'_manager')->edit($request->request->get(strtolower($this->checkFormEntity($this->entity)))['id'], $request->request->get(strtolower($this->checkFormEntity($this->entity))));
        } else {
            return null;
        }
    }

    /**
     * @param $sendaction
     * @param $request
     * @return null
     */
    private function retablirOrTransformArchivedItem($sendaction, $request)
    {
        if ($sendaction == "Rétablir") {
            $this->get('core.'.strtolower($this->entity).'_manager')->retablir($request->request->get(strtolower($this->entity))['id']);
            $this->isArchived = '1';
        } elseif ($sendaction == "Sauver et Transformer") {
            $this->get('core.mouv_history_manager')->add($request->request->get('candidat'), $this->get('app.user_manager')->getId($user = $this->get('security.token_storage')->getToken()->getUser()->getUsername()), 'C');
            $this->get('core.candidat_manager')->transformUser($request->request->get(strtolower($this->entity))['id']);
            $this->get('core.utilisateur_manager')->transform($request->request->get('candidat'));
        } else {
            return null;
        }
    }

    /**
     * @param $genEmail
     * @param $request
     */
    private function ifGmailNotNullCreate($genEmail, $request)
    {
        if (!is_null($genEmail)) {
            $this->get('core.google_api_service')->ifEmailNotExistCreateUser(array('nom' => $request->request->get('utilisateur')['name'], 'prenom' => $request->request->get('utilisateur')['surname'], 'email' => $request->request->get('genEmail'), 'password' => $request->request->get('utilisateur')['mainPassword']));
            $this->get('core.utilisateur_manager')->setEmail($request->request->get('utilisateur')['id'],$request->request->get('genEmail'));
        }
    }

    /**
     * @param Candidat $candidat
     * @return mixed
     */
    public function executeCreateTicket(Candidat $candidat)
    {
        return $this->get('core.zendesk_service')->createTicket(
            $candidat->getId(), $candidat->getName(), $candidat->getSurname(), $candidat->getEntiteHolding(), $candidat->getStartDate()->format("Y-m-d"),
            $this->getConvertion('agence', $candidat->getAgence())->getNameInZendesk(), $this->getConvertion('service', $candidat->getService())->getNameInZendesk(),
            $this->getConvertion('fonction', $candidat->getFonction())->getNameInZendesk(), $candidat->getStatusPoste(), 'xavier.arroues@aramisauto.com'
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

        if ($this->entity == 'Candidat' || $this->entity == 'Utilisateur') {
            $i = 0;
            foreach ($allItems as $item) {
                $item->setAgence($this->getConvertion('agence', $item->getAgence())->getName());
                $item->setFonction($this->getConvertion('fonction', $item->getFonction())->getName());
                $item->setService($this->getConvertion('service', $item->getService())->getName());
                $allItems = $this->filterView($allItems, $item, '0', $i);
                $allItems = $this->filterView($allItems, $item, '1', $i);
                $allItems = $this->filterView($allItems, $item, '2', $i);
                $i++;
            }
        }

        return $this->render('CoreBundle:'.$this->entity.':view.html.twig', array(
            'all' => $allItems,
            'message' => $this->message,
            'code_message' => $this->insert,
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
    public function executeRequestAddAction(Request $request)
    {
        $return = $this->checkErrorCode($this->get('core.'.strtolower($this->entity).'_manager')->add($request->request->get(strtolower($this->checkFormEntity($this->entity)))));
        $this->insert = $return['errorCode'];
        $this->message = $return['error'];
        if ($this->entity == 'Candidat') {
            $this->executeCreateTicket($return['candidat']);
        }
        return $this->getFullList($this->isArchived);
    }

    /**
     * @param $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function executeRequestEditAction($request)
    {
        if ($request->request->get('formAction') == 'edit') {
            $return = $this->checkErrorCode($this->saveEditIfSaveOrTransform($request->request->get('sendAction'), $request));
            $this->insert = $return['errorCode'];
            $this->message = $return['error'];
            $this->retablirOrTransformArchivedItem($request->request->get('sendAction'), $request);
            $this->ifGmailNotNullCreate($request->request->get('genEmail'), $request);
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