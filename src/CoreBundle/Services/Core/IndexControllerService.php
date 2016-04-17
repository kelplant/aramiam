<?php
namespace CoreBundle\Services\Core;


class IndexControllerService extends AbstractControllerService
{
    /**
     * @param $entity
     * @param $allItems
     * @return mixed
     */
    private function getListIfCandidatOrUtilisateur($entity, $allItems)
    {
        $i = 0;
        $item = null;
        foreach ($allItems as $item) {
            $this->ifFilterConvertService($item, $entity);
            $this->ifFilterConvertFonction($item, $entity);
            $this->ifFilterConvertAgence($item, $entity);
            $i++;
        }
        if ($entity == 'Candidat' || $entity == 'Utilisateur') {
            $allItems = $this->filterView($allItems, $item, '0', $i);
            $allItems = $this->filterView($allItems, $item, '1', $i);
            $allItems = $this->filterView($allItems, $item, '2', $i);
        }
        return $allItems;
    }

    /**
     * @param $isArchived
     * @param $formAdd
     * @param $formEdit
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getFullList($isArchived, $formAdd, $formEdit)
    {
        $allItems = $this->getListIfCandidatOrUtilisateur($this->entity, $this->get('core.'.strtolower($this->entity).'_manager')->getRepository()->findAll());

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

        return $this->getFullList($isArchived, $this->formAdd, $this->formEdit);
    }
}