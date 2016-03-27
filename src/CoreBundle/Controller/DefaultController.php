<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Aramis\OdigoServiceBundle\Entity\Core\OdigoServiceResponse as OdigoServiceResponse;

class DefaultController extends Controller
{
    /**
     * @param $companyPhone
     * @param $companyInternalPhone
     * @param $companyPrenom
     * @param $companyEmail
     * @param $companyNom
     * @param $companyPassword
     * @param $companyAgence
     * @param $companyService
     * @param $companyExtension
     * @return array
     */
    private function createWithTemplateArrayForRequestFromCompany($companyPhone,$companyInternalPhone,$companyPrenom,$companyEmail,$companyNom,$companyPassword,$companyAgence,$companyService,$companyExtension)
    {
        return $userBeanWithTemplateInfos = array(
            'active' => "1",
            'data' => $companyPhone,
            'ddiNumber' => $companyInternalPhone,
            'directAccessCode' => $companyPhone,
            'firstName' => $companyPrenom,
            'language' => "1",
            'listAgentGroup' => NULL,
            'listTemplate' => $companyAgence . "_" . $companyService,
            'mail' => $companyEmail,
            'name' => $companyNom,
            'overloadGroup' => "true",
            'overloadTemplate' => "true",
            'password' => $companyPassword,
            'phoneLoginNumber' => $companyPhone,
            'phoneLoginPassword' => NULL,
            'templateId' => $companyAgence . "_" . $companyService,
            'timeZone' => "fr",
            'userId' => $companyExtension,
            'skillId' => NULL,
            'skillLevel' => NULL
        );
    }

    /**
     * @param $companyInternalPhone
     * @param $companyPrenom
     * @param $companyEmail
     * @param $companyNom
     * @param $companyPassword
     * @param $companyAgence
     * @param $companyExtension
     * @return array
     */
    private function createArrayForRequestFromCompany($companyInternalPhone,$companyPrenom,$companyEmail,$companyNom,$companyPassword,$companyAgence,$companyExtension)
    {
        return $userBeanInfos = array(
            'activeState' => "1",
            'agentGroups' => "ga_" . strtoupper($companyAgence),
            'breaks' => NULL,
            'calendarId' => "GENERAL",
            'ddiNumber' => $companyInternalPhone,
            'disruptionDuration' => "15",
            'email' => $companyEmail,
            'enable2WaysSwitch' => "true",
            'enableCallBack' => "true",
            'enableConference' => "true",
            'enableOutCall' => "true",
            'enableRecording' => "true",
            'firstName' => $companyPrenom,
            'languageId' => "1",
            'loginTel' => $companyInternalPhone,
            'name' => $companyNom,
            'password' => $companyPassword,
            'transfertDDIAuthorized' => "true",
            'userId' => $companyExtension,
            'wrapupTime' => "15",
            'level' => "3",
            'skillKeyword' => "MARKET",
            'specialty' => "1",
        );
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $loadCreateAgentErrorsCodes = $this->getParameter('odigo_wsdl_error_createagent_codes');

        $userBeanInfos = $this->createArrayForRequestFromCompany("0622244545","XavTestWs","xavtestws@mail.fr","arrtestws","passwordtest","Aix","xavarrws");

        $create = $this->get('odigo.service.client')->create(
            $this->getParameter('odigo'),
            $userBeanInfos
        );
        echo "<br><br>";
        echo $loadCreateAgentErrorsCodes[$create];
        echo "<br><br>";


        $loadCreateUserWithTemplateErrorsCodes = $this->getParameter('odigo_wsdl_error_creatuserwithtemplate_codes');

        $userBeanWithTemplateInfos = $this->createWithTemplateArrayForRequestFromCompany("0405440404","0622544545","fdstTestWs","fdstestws@mail.fr","fdsttestws","passwordtest","Aix","CC","fdst");

        $createWithTemplate = $this->get('odigo.service.client')->createwithtemplate(
            $this->getParameter('odigo'),
            $userBeanWithTemplateInfos
        );
        echo "<br><br>";
        echo $loadCreateUserWithTemplateErrorsCodes[$createWithTemplate];
        echo "<br><br>";

        echo "<br><br>";

        return $this->render('CoreBundle:Default:index.html.twig');
    }

    public function deleteAction($companyExtensionId)
    {
        $loadDeleteErrorsCodes = $this->getParameter('odigo_wsdl_error_export_codes');

        $delete = $this->get('odigo.service.client')->delete(
            $this->getParameter('odigo'),
            $companyExtensionId
        );
        echo "<br><br>";
        echo $loadDeleteErrorsCodes[$delete];

        return $this->render('CoreBundle:Default:index.html.twig');
    }

    public function exportAction()
    {
        $loadExportErrorsCodes = $this->getParameter('odigo_wsdl_error_delete_codes');

        $export = $this->get('odigo.service.client')->export(
            $this->getParameter('odigo'),
            $this->getParameter('odigo_login')
        );
        echo "<br><br>";
        echo $loadExportErrorsCodes[$export];

        return $this->render('CoreBundle:Default:index.html.twig');
    }
}
