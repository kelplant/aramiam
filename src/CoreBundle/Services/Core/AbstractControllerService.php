<?php
namespace CoreBundle\Services\Core;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class AbstractControllerService
 * @package CoreBundle\Services\Core
 */
abstract class AbstractControllerService extends Controller
{
    protected $entity;

    protected $newEntity;

    protected $formType;

    protected $alertText;

    protected $isArchived;

    protected $createFormArguments;

    protected $formAdd;

    protected $formEdit;

    protected $servicePrefix;


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
        for ($i = 1; $i <= preg_match_all('/[A-Z]/', $entity, $matches, PREG_OFFSET_CAPTURE) - 1; $i++) {
            $entity = str_replace($matches[0][$i][0], '_'.$matches[0][$i][0], $entity);
        }
        return $entity;
    }

    /**
     *
     */
    protected function initBothForms()
    {
        $this->formAdd = $this->generateForm();
        $this->formEdit = $this->generateForm();
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
     * @param mixed $formAdd
     * @return AbstractControllerService
     */
    public function setFormAdd($formAdd)
    {
        $this->formAdd = $formAdd;
        return $this;
    }

    /**
     * @param mixed $formEdit
     * @return AbstractControllerService
     */
    public function setFormEdit($formEdit)
    {
        $this->formEdit = $formEdit;
        return $this;
    }

    /**
     * @param mixed $servicePrefix
     * @return AbstractControllerService
     */
    public function setServicePrefix($servicePrefix)
    {
        $this->servicePrefix = $servicePrefix;
        return $this;
    }
}