<?php
namespace OdigoApiBundle\Services;

use GoogleApiBundle\Services\GoogleApiService;
use CoreBundle\Services\Manager\Admin\FonctionManager;
use CoreBundle\Services\Manager\Admin\ServiceManager;
use CoreBundle\Services\Manager\Admin\UtilisateurManager;
use OdigoApiBundle\Services\Manager\OdigoTelListeManager;
use OdigoApiBundle\Services\Manager\OrangeTelListeManager;
use OdigoApiBundle\Services\Manager\ProsodieOdigoManager;

/**
 * Class OdigoApiService
 * @package OdigoApiBundle\Services
 */
class OdigoApiService
{
    protected $utilisateurManager;

    protected $odigoTelListeManager;

    protected $orangeTelListeManager;

    protected $prosodieOdigoManager;

    protected $serviceManager;

    protected $fonctionManager;

    protected $odigoServiceClient;

    protected $googleApiService;

    /**
     * OdigoApiService constructor.
     * @param UtilisateurManager $utilisateurManager
     * @param OdigoTelListeManager $odigoTelListeManager
     * @param OrangeTelListeManager $orangeTelListeManager
     * @param ProsodieOdigoManager $prosodieOdigoManager
     * @param ServiceManager $serviceManager
     * @param FonctionManager $fonctionManager
     * @param OdigoClientService $odigoServiceClient
     * @param GoogleApiService $googleApiService
     */
    public function __construct($utilisateurManager, $odigoTelListeManager, $orangeTelListeManager, $prosodieOdigoManager, $serviceManager, $fonctionManager, $odigoServiceClient, $googleApiService)
    {
        $this->utilisateurManager = $utilisateurManager;
        $this->odigoTelListeManager = $odigoTelListeManager;
        $this->orangeTelListeManager = $orangeTelListeManager;
        $this->prosodieOdigoManager = $prosodieOdigoManager;
        $this->serviceManager = $serviceManager;
        $this->fonctionManager = $fonctionManager;
        $this->odigoServiceClient = $odigoServiceClient;
        $this->googleApiService = $googleApiService;
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
     * @param $paramsOdigo
     * @return mixed
     */
    private function createOdigoUser($odigoTel, $redirectTel, $prenom, $email, $nom, $generalPassword, $odigoService, $odigoFonction, $odigoIdentfiant, $paramsOdigo)
    {
        $this->odigoServiceClient->createwithtemplate($paramsOdigo, $this->createWithTemplateArrayForRequest($odigoTel, $redirectTel, $prenom, $email, $nom, $generalPassword, $odigoService, $odigoFonction, $odigoIdentfiant));
    }

    /**
     * @param $odigoUserId
     * @param $paramsOdigo
     * @return mixed
     */
    public function deleteOdigoUser($odigoUserId, $paramsOdigo)
    {
        $this->odigoServiceClient->delete($paramsOdigo, $odigoUserId);
    }

    /**
     * @param $paramsOdigo
     * @return mixed
     */
    public function exportOdigoModifications($paramsOdigo)
    {
        $this->odigoServiceClient->export($paramsOdigo, $paramsOdigo['login']);
    }

    /**
     * @param $numAutre
     * @param $numOrange
     * @return mixed
     */
    private function numForOdigo($numAutre, $numOrange)
    {
        if ($numAutre != null || $numAutre != "") {
            return $numAutre;
        } else {
            $this->orangeTelListeManager->setNumOrangeInUse($numOrange);
            return $numOrange;
        }
    }

    /**
     * @param $sendaction
     * @param $isCreateInOdigo
     * @param $request
     * @param $paramsOdigo
     */
    public function ifOdigoCreate($sendaction, $isCreateInOdigo, $request, $paramsOdigo, $paramsGoogle)
    {
        if ($sendaction == "Créer sur Odigo" && $isCreateInOdigo == null) {
            $this->createOdigoUser($request->request->get('prosodie')['numProsodie'], $this->numForOdigo($request->request->get('prosodie')['autreNum'], $request->request->get('prosodie')['numOrange']), $request->request->get('utilisateur')['surname'], $request->request->get('utilisateur')['email'], $request->request->get('utilisateur')['name'], $request->request->get('utilisateur')['mainPassword'], $this->serviceManager->load($request->request->get('utilisateur')['service'])->getNameInOdigo(), $this->fonctionManager->load($request->request->get('utilisateur')['fonction'])->getNameInOdigo(), $request->request->get('prosodie')['identifiant'], $paramsOdigo);
            $this->exportOdigoModifications($paramsOdigo);
            $return = $this->prosodieOdigoManager->add(array('user' => $request->request->get('utilisateur')['id'], 'odigoPhoneNumber' => $request->request->get('prosodie')['numProsodie'], 'redirectPhoneNumber' => $this->numForOdigo($request->request->get('prosodie')['autreNum'], $request->request->get('prosodie')['numOrange']), 'odigoExtension'=> $request->request->get('prosodie')['identifiant']));
            $this->utilisateurManager->setIsCreateInOdigo($request->request->get('utilisateur')['id'], $return['item']->getId());
            $this->odigoTelListeManager->setNumProsodieInUse($request->request->get('prosodie')['numProsodie']);
            $this->googleApiService->addAliasToUser($paramsGoogle, $request->request->get('utilisateur')['email'], $request->request->get('prosodie')['numProsodie'].'@aramisauto.com');
        }
    }
}