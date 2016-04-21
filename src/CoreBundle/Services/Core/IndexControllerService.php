<?php
namespace CoreBundle\Services\Core;

class IndexControllerService extends AbstractControllerService
{
    /**
     * @param $service
     * @param $entity
     * @return mixed|null
     */
    private function ifFilterConvertService($service, $entity)
    {
        if ($entity == 'Candidat' || $entity == 'Utilisateur' || $entity == 'OdigoTelListe' || $entity == 'OrangeTelListe') {
            return $service->setService($this->getConvertion('service', $service->getService())->getName());
        } else {
            return null;
        }
    }

    /**
     * @param $fonction
     * @param $entity
     * @return mixed|null
     */
    private function ifFilterConvertFonction($fonction, $entity)
    {
        if ($entity == 'Candidat' || $entity == 'Utilisateur' || $entity == 'OdigoTelListe') {
            return $fonction->setFonction($this->getConvertion('fonction', $fonction->getFonction())->getName());
        } else {
            return null;
        }
    }

    /**
     * @param $agence
     * @param $entity
     * @return mixed|null
     */
    private function ifFilterConvertAgence($agence, $entity)
    {
        if ($entity == 'Candidat' || $entity == 'Utilisateur') {
            $agence->setAgence($this->getConvertion('agence', $agence->getAgence())->getName());
        }
    }

    /**
     * @param $allItems
     * @param $item
     * @param string $number
     * @param integer $i
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
     * @param $entity
     * @param $allItems
     * @return mixed
     */
    private function ifCandidatOUtilisateurList($entity, $allItems)
    {
        if ($entity == 'Candidat' || $entity == 'Utilisateur') {
            $i = 0;
            foreach ($allItems as $item) {
                $allItems = $this->filterView($allItems, $item, '0', $i);
                $allItems = $this->filterView($allItems, $item, '1', $i);
                $allItems = $this->filterView($allItems, $item, '2', $i);
                $i = $i + 1;
            }
        }
        return $allItems;
    }

    /**
     * @param $entity
     * @param $allItems
     * @return mixed
     */
    private function getListOfItems($entity, $allItems)
    {
        foreach ($allItems as $item) {
            $this->ifFilterConvertService($item, $entity);
            $this->ifFilterConvertFonction($item, $entity);
            $this->ifFilterConvertAgence($item, $entity);
        }
        $this->ifCandidatOUtilisateurList($entity, $allItems);

        return $allItems;
    }

    /**
     * @param $isArchived
     * @param $formAdd
     * @param $formEdit
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getFullList($isArchived, $formAdd, $formEdit, $optionMessage)
    {
        $allItems = $this->getListOfItems($this->entity, $this->get('core.'.strtolower($this->entity).'_manager')->getRepository()->findAll());

        if (!is_null($optionMessage)) {
            $this->message = $optionMessage['error'];
            $this->insert = $optionMessage['errorCode'];
        }

        return $this->render('CoreBundle:'.$this->entity.':view.html.twig', array(
            'all' => $allItems,
            'message' => $this->message,
            'code_message' => $this->insert,
            'remove_path' => 'remove_'.strtolower($this->entity),
            'alert_text' => $this->alertText,
            'is_archived' => $isArchived,
            'entity' => strtolower($this->checkFormEntity($this->entity)),
            'formAdd' => $formAdd->createView(),
            'formEdit' => $formEdit->createView(),
        ));
    }

    /**
     * @param $isArchived
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function generateIndexAction($isArchived)
    {
        $this->initBothForms();

        return $this->getFullList($isArchived, $this->formAdd, $this->formEdit, null);
    }
}