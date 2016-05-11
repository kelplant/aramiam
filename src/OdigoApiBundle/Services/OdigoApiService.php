<?php
namespace OdigoApiBundle\Services;

use GoogleApiBundle\Services\GoogleUserApiService;
use CoreBundle\Services\Manager\Admin\FonctionManager;
use CoreBundle\Services\Manager\Admin\ServiceManager;
use CoreBundle\Services\Manager\Admin\UtilisateurManager;
use Symfony\Component\HttpFoundation\Request;
use OdigoApiBundle\Services\Manager\OdigoTelListeManager;
use OdigoApiBundle\Services\Manager\OrangeTelListeManager;
use OdigoApiBundle\Services\Manager\ProsodieOdigoManager;
use SalesforceApiBundle\Services\SalesforceApiUserService;

/**
 * Class OdigoApiService
 * @package OdigoApiBundle\Services
 */
class OdigoApiService
{
    /**
     * @var UtilisateurManager
     */
    protected $utilisateurManager;

    /**
     * @var OdigoTelListeManager
     */
    protected $odigoTelListeManager;

    /**
     * @var OrangeTelListeManager
     */
    protected $orangeTelListeManager;

    /**
     * @var ProsodieOdigoManager
     */
    protected $prosodieOdigoManager;

    /**
     * @var ServiceManager
     */
    protected $serviceManager;

    /**
     * @var FonctionManager
     */
    protected $fonctionManager;

    /**
     * @var OdigoClientService
     */
    protected $odigoServiceClient;

    /**
     * @var GoogleUserApiService
     */
    protected $googleUserApiService;

    /**
     * @var SalesforceApiUserService;
     */
    protected $salesforceApiUserService;

    /**
     * OdigoApiService constructor.
     * @param UtilisateurManager $utilisateurManager
     * @param OdigoTelListeManager $odigoTelListeManager
     * @param OrangeTelListeManager $orangeTelListeManager
     * @param ProsodieOdigoManager $prosodieOdigoManager
     * @param ServiceManager $serviceManager
     * @param FonctionManager $fonctionManager
     * @param OdigoClientService $odigoServiceClient
     * @param GoogleUserApiService $googleUserApiService
     * @param SalesforceApiUserService $salesforceApiUserService
     */
    public function __construct(UtilisateurManager $utilisateurManager, OdigoTelListeManager $odigoTelListeManager, OrangeTelListeManager $orangeTelListeManager, ProsodieOdigoManager $prosodieOdigoManager, ServiceManager $serviceManager, FonctionManager $fonctionManager, OdigoClientService $odigoServiceClient, GoogleUserApiService $googleUserApiService, SalesforceApiUserService $salesforceApiUserService)
    {
        $this->utilisateurManager       = $utilisateurManager;
        $this->odigoTelListeManager     = $odigoTelListeManager;
        $this->orangeTelListeManager    = $orangeTelListeManager;
        $this->prosodieOdigoManager     = $prosodieOdigoManager;
        $this->serviceManager           = $serviceManager;
        $this->fonctionManager          = $fonctionManager;
        $this->odigoServiceClient       = $odigoServiceClient;
        $this->googleUserApiService     = $googleUserApiService;
        $this->salesforceApiUserService = $salesforceApiUserService;
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
     * @param Request $request
     * @param $userId
     * @param $paramsOdigo
     * @param $paramsGoogle
     */
    public function deleteOdigoUser($sendaction, Request $request, $userId, $paramsOdigo, $paramsGoogle, $salesforceParams)
    {
        if ($sendaction == "Supprimer dans Odigo") {
            $userLinkInfos = $this->prosodieOdigoManager->getRepository()->findOneByUser($userId);
            $this->odigoServiceClient->delete($paramsOdigo, $userLinkInfos->getOdigoExtension());
            $this->exportOdigoModifications($paramsOdigo);
            $this->utilisateurManager->edit($userId, array('isCreateInOdigo' => 0));
            $this->prosodieOdigoManager->remove($userLinkInfos->getId());
            $this->odigoTelListeManager->editByNumero($userLinkInfos->getOdigoPhoneNumber(), array('inUse' => 0));
            if ($userLinkInfos->isRedirectFromAramis() == true) {
                $this->orangeTelListeManager->editByNumero($userLinkInfos->getOdigoPhoneNumber(), array('inUse' => 0));
            }
            $this->googleUserApiService->deleteAliasToUser($paramsGoogle, $request->request->get('utilisateur')['email'], $request->request->get('prosodie')['numProsodie'].'@aramisauto.com');
            $tabToSend = array('utilisateurId' => $request->request->get('utilisateur')['id'], 'newDatas' => array('givenName' => $request->request->get('utilisateur')['surname'], 'displayName' => $request->request->get('utilisateur')['viewName'], 'sn' => $request->request->get('utilisateur')['name'], 'mail' => $request->request->get('utilisateur')['email']), 'utilisateurService' => $request->request->get('utilisateur')['service'], 'utilisateurFonction' => $request->request->get('utilisateur')['fonction'], 'utilisateurOldService' => $request->request->get('utilisateur')['service'], 'utilisateurOldEmail' => $request->request->get('utilisateur')['fonction'], 'request' => $request->request);
            $this->salesforceApiUserService->ifUserUpdated($tabToSend, $salesforceParams);
        }
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
     * @param $sendaction
     * @param Request $request
     * @param $paramsOdigo
     * @param $paramsGoogle
     * @param $salesforceParams
     */
    public function ifOdigoCreate($sendaction, Request $request, $paramsOdigo, $paramsGoogle, $salesforceParams)
    {
        if ($sendaction == "Créer sur Odigo") {
            $this->createOdigoUser($request->request->get('prosodie')['numProsodie'], $this->numForOdigo($request->request->get('prosodie')['autreNum'], $request->request->get('prosodie')['numOrange']), $request->request->get('utilisateur')['surname'], $request->request->get('utilisateur')['email'], $request->request->get('utilisateur')['name'], $request->request->get('utilisateur')['mainPassword'], $this->serviceManager->load($request->request->get('utilisateur')['service'])->getNameInOdigo(), $this->fonctionManager->load($request->request->get('utilisateur')['fonction'])->getNameInOdigo(), $request->request->get('prosodie')['identifiant'], $paramsOdigo);
            $redirectFromAramis = true;
            if ($request->request->get('prosodie')['autreNum'] != null || $request->request->get('prosodie')['autreNum'] != "") {
                $redirectFromAramis = false;
            }
            $this->exportOdigoModifications($paramsOdigo);
            $return = $this->prosodieOdigoManager->add(array('user' => $request->request->get('utilisateur')['id'], 'odigoPhoneNumber' => $request->request->get('prosodie')['numProsodie'], 'redirectFromAramis' => $redirectFromAramis, 'redirectPhoneNumber' => $this->numForOdigo($request->request->get('prosodie')['autreNum'], $request->request->get('prosodie')['numOrange']), 'odigoExtension'=> $request->request->get('prosodie')['identifiant'], 'profilBase' =>$this->serviceManager->load($request->request->get('utilisateur')['service'])->getNameInOdigo().'_'.$this->fonctionManager->load($request->request->get('utilisateur')['fonction'])->getNameInOdigo()));
            $this->utilisateurManager->setIsCreateInOdigo($request->request->get('utilisateur')['id'], $return['item']->getId());
            $this->odigoTelListeManager->setNumProsodieInUse($request->request->get('prosodie')['numProsodie']);
            $this->googleUserApiService->addAliasToUser($paramsGoogle, $request->request->get('utilisateur')['email'], $request->request->get('prosodie')['numProsodie'].'@aramisauto.com');
            $tabToSend = array('utilisateurId' => $request->request->get('utilisateur')['id'], 'newDatas' => array('givenName' => $request->request->get('utilisateur')['surname'], 'displayName' => $request->request->get('utilisateur')['viewName'], 'sn' => $request->request->get('utilisateur')['name'], 'mail' => $request->request->get('utilisateur')['email']), 'utilisateurService' => $request->request->get('utilisateur')['service'], 'utilisateurFonction' => $request->request->get('utilisateur')['fonction'], 'utilisateurOldService' => $request->request->get('utilisateur')['service'], 'utilisateurOldEmail' => $request->request->get('utilisateur')['fonction'], 'request' => $request->request);
            $this->salesforceApiUserService->ifUserUpdated($tabToSend, $salesforceParams);
        }
    }
}