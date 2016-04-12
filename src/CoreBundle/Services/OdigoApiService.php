<?php
namespace CoreBundle\Services;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class OdigoApiService extends Controller
{
    /**
     * @param $odigoTel
     * @param $redirectTel
     * @param $prenom
     * @param $email
     * @param $nom
     * @param $generalPassword
     * @param $odigoService
     * @param $odigoFonction
     * @param $odigoIdentfiant
     * @return array
     */
    private function createWithTemplateArrayForRequest($odigoTel, $redirectTel, $prenom, $email, $nom, $generalPassword, $odigoService, $odigoFonction, $odigoIdentfiant)
    {
        return array('active' => "1", 'data' => $odigoTel, 'ddiNumber' => $redirectTel, 'directAccessCode' => $odigoTel, 'firstName' => $prenom, 'language' => "1", 'listAgentGroup' => NULL, 'listTemplate' => $odigoService."_".$odigoFonction, 'mail' => $email, 'name' => $nom, 'overloadGroup' => "true", 'overloadTemplate' => "true", 'password' => $generalPassword, 'phoneLoginNumber' => $odigoTel, 'phoneLoginPassword' => NULL, 'templateId' => $odigoService."_".$odigoFonction, 'timeZone' => "fr", 'userId' => $odigoIdentfiant, 'skillId' => NULL, 'skillLevel' => NULL);
    }

    /**
     * @param $odigoTel
     * @param $redirectTel
     * @param $prenom
     * @param $email
     * @param $nom
     * @param $generalPassword
     * @param $odigoService
     * @param $odigoFonction
     * @param $odigoIdentfiant
     * @return mixed
     */
    public function createOdigoUser($odigoTel, $redirectTel, $prenom, $email, $nom, $generalPassword, $odigoService, $odigoFonction, $odigoIdentfiant)
    {
        $createWithTemplate = $this->get('odigo.service.client')->createwithtemplate($this->getParameter('odigo'), $this->createWithTemplateArrayForRequest($odigoTel, $redirectTel, $prenom, $email, $nom, $generalPassword, $odigoService, $odigoFonction, $odigoIdentfiant));
        return $this->getParameter('odigo_wsdl_error_creatuserwithtemplate_codes')[$createWithTemplate];
    }

    /**
     * @param $odigoUserId
     * @return mixed
     */
    public function deleteOdigoUser($odigoUserId)
    {
        $delete = $this->get('odigo.service.client')->delete($this->getParameter('odigo'), $odigoUserId);
        return $this->getParameter('odigo_wsdl_error_export_codes')[$delete];
    }

    /**
     * @return mixed
     */
    public function exportOdigoModifications()
    {
        $export = $this->get('odigo.service.client')->export($this->getParameter('odigo'), $this->getParameter('odigo_login'));
        return $this->getParameter('odigo_wsdl_error_export_codes')[$export];
    }
}