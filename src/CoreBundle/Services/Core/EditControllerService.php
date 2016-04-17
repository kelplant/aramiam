<?php
namespace CoreBundle\Services\Core;

/**
 * Class EditControllerService
 * @package CoreBundle\Services\Core
 */
class EditControllerService extends AbstractControllerService
{
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
     * @param $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function executeRequestEditAction($request)
    {
        if ($request->request->get('formAction') == 'edit') {
            $return = $this->checkErrorCode($this->saveEditIfSaveOrTransform($request->request->get('sendAction'), $request));
            $this->insert = $return['errorCode'];
            $this->message = $return['error'];
            $this->retablirOrTransformArchivedItem($request->request->get('sendaction'), $request);
            $this->get('core.google_api_service')->ifGmailCreate($request->request->get('sendaction'), $request->request->get('utilisateur')['isCreateInGmail'], $request, $this->getParameter('google_api'));
            $this->get('core.odigo_api_service')->ifOdigoCreate($request->request->get('sendaction'), $request->request->get('utilisateur')['isCreateInOdigo'], $request,$this->getParameter('odigo'), $this->getParameter('odigo_wsdl_error_creatuserwithtemplate_codes'));
            $this->get('core.active_directory_api_service')->ifWindowsCreate($request->request->get('sendaction'), $request->request->get('utilisateur')['isCreateInWindows'], $request, $this->getParameter('active_directory'));
            $this->get('core.salesforce_api_service')->ifSalesforceCreate($request->request->get('sendaction'), $request->request->get('utilisateur')['isCreateInSalesforce'], $request);
        }
        return $this->get('core.index.controller_service')->getFullList($this->isArchived);
    }
}