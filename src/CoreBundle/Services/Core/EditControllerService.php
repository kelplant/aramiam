<?php
namespace CoreBundle\Services\Core;

/**
 * Class EditControllerService
 * @package CoreBundle\Services\Core
 */
class EditControllerService extends AbstractControllerService
{
    /**
     * @param $request
     */
    private function ifSfServiceCloudInFonctionAdd($request)
    {
        if ($this->entity == 'Fonction' && isset($request->request->get('salesforce')['service_cloud_acces'])) {
            $this->get('salesforce.service_cloud_acces_manager')->setFonctionAcces($request->request->get('fonction')['id'], $request->request->get('salesforce')['service_cloud_acces']);
        }
    }

    /**
     * @param $request
     */
    private function ifSfGroupePresentInFonctionAdd($request)
    {
        if ($this->entity == 'Fonction') {
            if ($request->request->get('salesforce') != '') {
                foreach ($request->request->get('salesforce') as $key => $value) {
                    if (substr($key, 0, 6) == 'groupe') {
                        $this->get('salesforce.groupe_to_fonction_manager')->add(array('salesforceGroupe' => $value, 'fonctionId' => $request->request->get('fonction')['id']));
                    }
                }
            }
        }
    }

    /**
     * @param $request
     */
    private function ifSfTerritoryPresentInServiceAdd($request)
    {
        if ($this->entity == 'Service') {
            if ($request->request->get('salesforce') != '') {
                foreach ($request->request->get('salesforce') as $key => $value) {
                    if (substr($key, 0, 9) == 'territory') {
                        $this->get('salesforce.territory_to_service_manager')->add(array('salesforceTerritoryId' => $value, 'serviceId' => $request->request->get('service')['id']));
                    }
                }
            }
        }
    }

    /**
     * @param $sendaction
     * @param $request
     * @return mixed|null
     */
    private function saveEditIfSaveOrTransform($sendaction, $request)
    {
        if ($sendaction == "Sauvegarder" || $sendaction == "Sauver et Transformer") {
            $this->ifSfServiceCloudInFonctionAdd($request);
            $this->ifSfTerritoryPresentInServiceAdd($request);
            $this->get('salesforce.groupe_to_fonction_manager')->purge($request->request->get('fonction')['id']);
            $this->ifSfGroupePresentInFonctionAdd($request);
            return  $this->get($this->servicePrefix.'.'.strtolower($this->entity).'_manager')->edit($request->request->get(strtolower($this->checkFormEntity($this->entity)))['id'], $request->request->get(strtolower($this->checkFormEntity($this->entity))));
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
            $this->get($this->servicePrefix.'.'.strtolower($this->entity).'_manager')->retablir($request->request->get(strtolower($this->entity))['id']);
            $this->isArchived = '1';
        }
        if ($sendaction == "Sauver et Transformer") {
            $this->get('app.mouv_history_manager')->add($request->request->get('candidat'), $this->get('app.user_manager')->getId($this->get('security.token_storage')->getToken()->getUser()->getUsername()), 'C');
            $this->get('core.candidat_manager')->transformUser($request->request->get(strtolower($this->entity))['id']);
            $this->get('core.utilisateur_manager')->transform($request->request->get('candidat'));
        }
    }


    /**
     * @param $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function executeRequestEditAction($request)
    {
        $this->initBothForms();
        $this->formEdit->handleRequest($request);
        if ($this->formEdit->isSubmitted() && $this->formEdit->isValid()) {
            if ($request->request->get('formAction') == 'edit') {
                $this->saveEditIfSaveOrTransform($request->request->get('sendAction'), $request);
                $this->retablirOrTransformArchivedItem($request->request->get('sendaction'), $request);
                $this->get('google.google_api_service')->ifGmailCreate($request->request->get('sendaction'), $request->request->get('utilisateur')['isCreateInGmail'], $request, $this->getParameter('google_api'));
                $this->get('odigo.odigo_api_service')->ifOdigoCreate($request->request->get('sendaction'), $request->request->get('utilisateur')['isCreateInOdigo'], $request, $this->getParameter('odigo'), $this->getParameter('odigo_wsdl_error_creatuserwithtemplate_codes'));
                $this->get('ad.active_directory_api_service')->ifWindowsCreate($request->request->get('sendaction'), $request->request->get('utilisateur')['isCreateInWindows'], $request, $this->getParameter('active_directory'));
                $this->get('salesforce.salesforce_api_service')->ifSalesforceCreate($request->request->get('sendaction'), $request->request->get('utilisateur')['isCreateInSalesforce'], $request, $this->getParameter('salesforce'));
            }
        }

        return $this->get('core.index.controller_service')->getFullList($this->isArchived, $this->formAdd, $this->formEdit);
    }
}