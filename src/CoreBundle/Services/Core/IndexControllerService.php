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
        }
        return null;
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
        }
        return null;
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
        return null;
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
        return $allItems;
    }

    /**
     * @param $entity
     * @return mixed
     */
    private function ifCandidatOUtilisateurList($entity)
    {
        if ($entity == 'Candidat' || $entity == 'Utilisateur') {
            return $this->get($this->servicePrefix.'.'.strtolower($this->entity).'_manager')->getRepository()->findBy(array('isArchived' => $this->isArchived));
        } else {
            return $this->get($this->servicePrefix.'.'.strtolower($this->entity).'_manager')->getRepository()->findAll();
        }
    }

    /**
     * @param $session_messaging
     * @return string
     */
    private function getGlobalAlertColor($session_messaging)
    {
        $globalAlertColor = 0;
        if (isset($session_messaging)) {
            foreach ($session_messaging as $message) {
                if ($message['errorCode'] == 0 && $globalAlertColor == 0) {
                    $globalAlertColor = 'success';
                } else {
                    $globalAlertColor = 'danger';
                }
            }
        } else {
            $globalAlertColor = '';
        }
        return $globalAlertColor;
    }

    /**
     * @param $checkDate
     * @return string
     */
    public function colorForCandidatSlider($checkDate)
    {
        if (date("Y-m-d", time() + 604800 ) < $checkDate)
        {
            return 'green';
        } else {
            return 'red';
        }
    }

    /**
     * @param $isArchived
     * @param $formAdd
     * @param $formEdit
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getFullList($isArchived, $formAdd, $formEdit)
    {
        $allItems = $this->getListOfItems($this->entity, $this->ifCandidatOUtilisateurList($this->entity));
        $session_messaging = $this->get('session')->get('messaging');
        $this->get('session')->set('messaging', []);
        $globalAlertColor = $this->getGlobalAlertColor($session_messaging);

        $candidatListe = $this->get('core.candidat_manager')->getRepository()->findBy(array('isArchived' => '0'), array('startDate' => 'ASC'));

        return $this->render(explode("\\", $this->newEntity)[0].':'.$this->entity.':view.html.twig', array(
            'all'               => $allItems,
            'remove_path'       => 'remove_'.strtolower($this->entity),
            'alert_text'        => $this->alertText,
            'is_archived'       => $isArchived,
            'entity'            => strtolower($this->checkFormEntity($this->entity)),
            'nb_candidat'       => count($candidatListe),
            'candidat_color'    => $this->colorForCandidatSlider($candidatListe[0]->getStartDate()->format("Y-m-d")),
            'formAdd'           => $formAdd->createView(),
            'formEdit'          => $formEdit->createView(),
            'session_messaging' => $session_messaging,
            'currentUserInfos'  => $this->get('security.token_storage')->getToken()->getUser(),
            'userPhoto'         => $this->get('google.google_api_service')->base64safeToBase64(stream_get_contents($this->get('security.token_storage')->getToken()->getUser()->getPhoto())),
            'globalAlertColor'  => $globalAlertColor,
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