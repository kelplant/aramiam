<?php
namespace CoreBundle\Services\Core;

class IndexControllerService extends AbstractControllerService
{
    /**
     * @return array
     */
    public function generateAppsTable()
    {
        $listGroups = $this->get('launcher.launcher_app_group_manager')->getRepository()->findBy(array(), array('groupOrder' => 'ASC'));
        $finalTab = [];
        foreach ($listGroups as $group) {
            $listApps = $this->get('launcher.launcher_app_manager')->getRepository()->findBy(array('groupId' => $group->getId()), array('tilesOrder' => 'ASC'));
            $middleTab = [];
            foreach ($listApps as $app) {
                $middleTab[] = array('appName' => $app->getAppName(), 'appDescription' => $app->getAppDescription(), 'titleHeight' => $app->getTitleHeight(), 'tilesLenght' => $app->getTilesLenght(), 'tilesColor' => $app->getTilesColor(), 'icon' => $app->getIcon(), 'groupId' => $app->getGroupId(), 'tilesOrder' => $app->getTilesOrder(), 'urlLink' => $app->getUrlLink());
            }
            $finalTab[] = array('groupId' => $group->getId(), 'groupName' => $group->getGroupName(), 'groupOrder' => $group->getGroupOrder(), 'apps' => $middleTab);
        }
        return $finalTab;
    }

    /**
     * @param $service
     * @param $entity
     * @return mixed|null
     */
    public function ifFilterConvertService($service, $entity)
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
    public function ifFilterConvertFonction($fonction, $entity)
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
    public function ifFilterConvertAgence($agence, $entity)
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
     * @param $isArchived
     * @return mixed
     */
    private function ifCandidatOUtilisateurList($entity, $isArchived)
    {
        if ($entity == 'Candidat' || $entity == 'Utilisateur') {
            return $this->get($this->servicePrefix.'.'.strtolower($this->entity).'_manager')->getlist($isArchived);
        } else {
            return $this->getListOfItems($this->entity, $this->get($this->servicePrefix.'.'.strtolower($this->entity).'_manager')->getRepository()->findAll());
        }
    }


    /**
     * @param $message_errorCode
     * @param $globalAlertColor
     * @return string
     */
    private function returnGoodcolor($message_errorCode, $globalAlertColor)
    {
        if ($message_errorCode == 0 && $globalAlertColor == 0) {
            return 'success';
        } else {
            return 'danger';
        }
    }

    /**
     * @param $session_messaging
     * @return string
     */
    public function getGlobalAlertColor($session_messaging)
    {
        $globalAlertColor = 0;
        if (isset($session_messaging)) {
            foreach ($session_messaging as $message) {
                $globalAlertColor = $this->returnGoodcolor($message['errorCode'], $globalAlertColor);
            }
            return $globalAlertColor;
        } else {
            return '';
        }
    }

    /**
     * @param $checkDate
     * @return string
     */
    public function colorForCandidatSlider($checkDate)
    {
        if (date("Y-m-d", time() + 604800) < $checkDate)
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
        $allItems = $this->ifCandidatOUtilisateurList($this->entity, $isArchived);
        $session_messaging = $this->get('session')->get('messaging');
        $this->get('session')->set('messaging', []);
        $globalAlertColor = $this->getGlobalAlertColor($session_messaging);
        $candidatListe = $this->get('core.candidat_manager')->getRepository()->findBy(array('isArchived' => '0'), array('startDate' => 'ASC'));
        $userInfos = $this->get('security.token_storage')->getToken()->getUser();
        $myProfil = $this->get('core.utilisateur_manager')->load($this->get('ad.active_directory_user_link_manager')->getRepository()->findOneByIdentifiant($userInfos->getUsername())->getUser());

        return $this->render(explode("\\", $this->newEntity)[0].':'.$this->entity.':view.html.twig', array(
            'all'                           => $allItems,
            'manager'                       => $this->get('core.manager_service_link_manager')->isManager($myProfil->getId()),
            'panel'                         => 'admin',
            'utilisateursList'              => $this->get("core.utilisateur_manager")->createListForSelect(),
            'remove_path'                   => 'remove_'.strtolower($this->entity), 
            'alert_text'                    => $this->alertText,
            'is_archived'                   => $isArchived,
            'entity'                        => strtolower($this->checkFormEntity($this->entity)),
            'nb_candidat'                   => count($candidatListe),
            'candidat_color'                => $this->colorForCandidatSlider($candidatListe[0]->getStartDate()->format("Y-m-d")),
            'formAdd'                       => $formAdd->createView(), 'formEdit'  => $formEdit->createView(), 'session_messaging' => $session_messaging,
            'currentUserInfos'              => $userInfos,
            'userPhoto'                     => $this->get('google.google_user_api_service')->base64safeToBase64(stream_get_contents($userInfos->getPhoto())),
            'globalAlertColor'              => $globalAlertColor,
            'remaining_gmail_licenses'      => $this->get('app.parameters_calls')->getParam('remaining_google_licenses'),
            'remaining_salesforce_licenses' => $this->get('app.parameters_calls')->getParam('remaining_licences_type_Salesforce'),
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