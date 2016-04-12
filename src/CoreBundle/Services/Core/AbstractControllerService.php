<?php
namespace CoreBundle\Services\Core;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use CoreBundle\Entity\Admin\Candidat;

/**
 * Class AbstractControllerService
 * @package CoreBundle\Services\Core
 */
abstract class AbstractControllerService extends Controller
{
    protected $message;

    protected $insert;

    protected $entity;

    protected $newEntity;

    protected $formType;

    protected $alertText;

    protected $isArchived;

    protected $createFormArguments;

    protected $remove;

    protected $formItem;

    /**
     * @param $item
     * @return mixed
     */
    protected function generateMessage($item)
    {
        $this->message = $this->getParameter(strtolower($this->entity).'_insert_exceptions');
        return $this->message = $this->message[$item];
    }

    /**
     * @param $return
     * @return array
     */
    protected function checkErrorCode($return)
    {
        if ($return['errorCode'] === true) {
            return array('errorCode' => $return['errorCode'], 'error' => $return['error'], 'item' => $return['item']);
        } elseif ($return['errorCode'] == 6669 || $return['errorCode'] == 6667) {
            return array('errorCode' => $return['errorCode'], 'error' => $this->generateMessage($return['errorCode']), 'item' => $return['item']);
        } else {
            return array('errorCode' => null, 'error' => null, 'item' => null);
        }
    }

    /**
     * @return \Symfony\Component\Form\Form
     */
    protected function generateForm()
    {
        return $this->createForm($this->formType, new $this->newEntity, $this->createFormArguments);
    }

    /**
     * @param string $manager
     * @param $what
     * @return mixed
     */
    protected function getConvertion($manager, $what)
    {
        return $this->get('core.'.$manager.'_manager')->getRepository()->findOneById($what);
    }

    /**
     * @param $entity
     * @return string
     */
    protected function checkFormEntity($entity)
    {
        $majInEntity = preg_match_all('/[A-Z]/', $entity, $matches, PREG_OFFSET_CAPTURE);
        if ($majInEntity > 1) {
            for ($i = 1; $i <= $majInEntity; $i++) {
                return str_replace($matches[0][$i][0], '_'.$matches[0][$i][0], $this->entity);
            }
        } else {
            return $entity;
        }
    }

    /**
     * @param $entity
     * @param $allItems
     * @return mixed
     */
    private function getListIfCandidatOrUtilisateur($entity, $allItems)
    {
        if ($entity == 'Candidat' || $entity == 'Utilisateur') {
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

        return $allItems;
    }

    /**
     * @param $allItems
     * @param $item
     * @param string $number
     * @param integer $i
     * @return mixed
     */
    protected function filterView($allItems, $item, $number, $i)
    {
        if ($item->getIsArchived() != $number && $this->isArchived == $number) {
            unset($allItems[$i]);
        }
        return $allItems;
    }

    /**
     * @return array
     */
    public function generateListeChoices()
    {
        $listeChoices = [];
        $listeChoices['listeFonctions'] = $this->get("core.fonction_manager")->createList();
        $listeChoices['listeAgences'] = $this->get("core.agence_manager")->createList();
        $listeChoices['listeServices'] = $this->get("core.service_manager")->createList();
        $listeChoices['listeUtilisateurs'] = $this->get("core.utilisateur_manager")->createList();
        $listeChoices['listeEntites'] = $this->get("core.entite_holding_manager")->createList();

        return $listeChoices;
    }

    /**
     * @param $isArchived
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getFullList($isArchived)
    {
        $formAdd = $this->generateForm();
        $formEdit = $this->generateForm();
        $allItems = $this->getListIfCandidatOrUtilisateur($this->entity, $this->get('core.'.strtolower($this->entity).'_manager')->getRepository()->findAll());

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
     * @param $message
     * @return $this
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @param $insert
     * @return $this
     */
    public function setInsert($insert)
    {
        $this->insert = $insert;
        return $this;
    }

    /**
     * @param $entity
     * @return $this
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
        return $this;
    }

    /**
     * @param $newEntity
     * @return $this
     */
    public function setNewEntity($newEntity)
    {
        $this->newEntity = $newEntity;
        return $this;
    }

    /**
     * @param $formType
     * @return $this
     */
    public function setFormType($formType)
    {
        $this->formType = $formType;
        return $this;
    }

    /**
     * @param $alertText
     * @return $this
     */
    public function setAlertText($alertText)
    {
        $this->alertText = $alertText;
        return $this;
    }

    /**
     * @param $isArchived
     * @return $this
     */
    public function setIsArchived($isArchived)
    {
        $this->isArchived = $isArchived;
        return $this;
    }

    /**
     * @param $createFormArguments
     * @return $this
     */
    public function setCreateFormArguments($createFormArguments)
    {
        $this->createFormArguments = $createFormArguments;
        return $this;
    }

    /**
     * @param $remove
     * @return $this
     */
    public function setRemove($remove)
    {
        $this->remove = $remove;
        return $this;
    }

    /**
     * @param $formItem
     * @return $this
     */
    public function setFormItem($formItem)
    {
        $this->formItem = $formItem;
        return $this;
    }
}