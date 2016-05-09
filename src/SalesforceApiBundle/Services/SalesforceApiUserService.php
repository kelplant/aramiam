<?php
namespace SalesforceApiBundle\Services;


use SalesforceApiBundle\Factory\SalesforceUserFactory;
use CoreBundle\Services\Manager\Admin\AgenceManager;
use CoreBundle\Services\Manager\Admin\FonctionManager;
use CoreBundle\Services\Manager\Admin\ServiceManager;
use AramisApiBundle\Services\Manager\AramisAgencyManager;
use OdigoApiBundle\Services\Manager\ProsodieOdigoManager;
use AppBundle\Services\Manager\ParametersManager;
use SalesforceApiBundle\Services\Manager\SalesforceServiceCloudAccesManager;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;


class SalesforceApiUserService
{
    /**
     * @var SalesforceApiService
     */
    protected $salesforceApiService;

    /**
     * @var SalesforceUserFactory
     */
    protected $salesforceUserFactory;

    /**
     * @var ProsodieOdigoManager
     */
    protected $prosodieOdigo;

    /**
     * @var AgenceManager
     */
    protected $agenceManager;

    /**
     * @var ServiceManager
     */
    protected $serviceManager;

    /**
     * @var FonctionManager
     */
    protected $fonctionManager;

    /**
     * @var ParametersManager
     */
    protected $parametersManager;

    /**
     * @var AramisAgencyManager
     */
    protected $aramisAgencyManager;

    /**
     * @var SalesforceServiceCloudAccesManager
     */
    protected $serviceCloudAccesManager;

    /**
     * @var SalesforceApiGroupesServices
     */
    protected $salesforceApiGroupesService;

    /**
     * @var SalesforceApiTerritoriesServices
     */
    protected $salesforceApiTerritoriesService;

    /**
     * SalesforceApiUserService constructor.
     * @param SalesforceApiService $salesforceApiService
     * @param SalesforceUserFactory $salesforceUserFactory
     * @param ProsodieOdigoManager $prosodieOdigo
     * @param AgenceManager $agenceManager
     * @param ServiceManager $serviceManager
     * @param FonctionManager $fonctionManager
     * @param ParametersManager $parametersManager
     * @param AramisAgencyManager $aramisAgencyManager
     * @param SalesforceServiceCloudAccesManager $serviceCloudAccesManager
     * @param SalesforceApiGroupesServices $salesforceApiGroupesService
     * @param SalesforceApiTerritoriesServices $salesforceApiTerritoriesService
     */
    public function __construct(SalesforceApiService $salesforceApiService, SalesforceUserFactory $salesforceUserFactory, ProsodieOdigoManager $prosodieOdigo, AgenceManager $agenceManager, ServiceManager $serviceManager, FonctionManager $fonctionManager, ParametersManager $parametersManager, AramisAgencyManager $aramisAgencyManager, SalesforceServiceCloudAccesManager $serviceCloudAccesManager, SalesforceApiGroupesServices $salesforceApiGroupesService, SalesforceApiTerritoriesServices $salesforceApiTerritoriesService)
    {
        $this->salesforceApiService            = $salesforceApiService;
        $this->salesforceUserFactory           = $salesforceUserFactory;
        $this->prosodieOdigo                   = $prosodieOdigo;
        $this->agenceManager                   = $agenceManager;
        $this->serviceManager                  = $serviceManager;
        $this->fonctionManager                 = $fonctionManager;
        $this->parametersManager               = $parametersManager;
        $this->aramisAgencyManager             = $aramisAgencyManager;
        $this->serviceCloudAccesManager        = $serviceCloudAccesManager;
        $this->salesforceApiGroupesService     = $salesforceApiGroupesService;
        $this->salesforceApiTerritoriesService = $salesforceApiTerritoriesService;
    }

    /**
     * @param $lastName
     * @param $firstName
     * @return string
     */
    private function shortNickName($lastName, $firstName)
    {
        return iconv('utf-8', 'ascii//TRANSLIT', strtolower(substr($firstName, 0, 3).str_replace(" ", "", str_replace("-", "", $lastName))));
    }

    /**
     * @param $isCreatedInOdigo
     * @param $callCenterId
     * @return array
     */
    private function ifOdigoCreated($isCreatedInOdigo, $callCenterId)
    {
        if ($isCreatedInOdigo != 0) {
            $odigoInfos = $this->prosodieOdigo->load($isCreatedInOdigo);

            return array('callCenterId' => $callCenterId, 'odigoExtension' => $odigoInfos->getOdigoExtension(), 'odigoPhoneNumber' => $odigoInfos->getOdigoPhoneNumber(), 'redirectPhoneNumber' => $odigoInfos->getRedirectPhoneNumber());
        } else {
            return array('callCenterId' => null, 'odigoExtension' => null, 'odigoPhoneNumber' => null, 'redirectPhoneNumber' => null);
        }
    }

    /**
     * @param $sendaction
     * @param $isCreateInSalesforce
     * @param Request $request
     * @param $params
     */
    public function ifSalesforceCreate($sendaction, $isCreateInSalesforce, Request $request, $params)
    {
        if ($sendaction == "Créer sur Salesforce" && ($isCreateInSalesforce == null || $isCreateInSalesforce == 0)) {
            $paramsForSalesforceApi = $this->parametersManager->getAllAppParams('salesforce_api');
            $nickname = $this->shortNickName($request->request->get('utilisateur')['name'], $request->request->get('utilisateur')['surname']);
            $odigoInfos = $this->ifOdigoCreated($request->request->get('utilisateur')['isCreateInOdigo'], $paramsForSalesforceApi["salesforce_odigo_cti_id"]);
            $agenceCompany = $this->aramisAgencyManager->load($this->agenceManager->load($request->request->get('utilisateur')['agence'])->getNameInCompany());
            $newSalesforceUser = $this->salesforceUserFactory->createFromEntity(
                array(
                    'Username' => $request->request->get('utilisateur')['email'],
                    'LastName' => $request->request->get('utilisateur')['name'],
                    'FirstName' => $request->request->get('utilisateur')['surname'],
                    'Email' => $request->request->get('utilisateur')['email'],
                    'TimeZoneSidKey' => 'Europe/Paris',
                    'Alias' => substr($nickname, 0, 8),
                    'CommunityNickname' => $nickname."aramisauto",
                    'IsActive' => true,
                    'LocaleSidKey' => "fr_FR",
                    'EmailEncodingKey' => "ISO-8859-1",
                    'ProfileId' => $request->request->get('salesforce')['profile'],
                    'LanguageLocaleKey' => "FR",
                    'UserPermissionsMobileUser' => true,
                    'UserPreferencesDisableAutoSubForFeeds' => false,
                    'CallCenterId' => $odigoInfos['callCenterId'],
                    'Street' => $agenceCompany->getAddress1(),
                    'City' => $agenceCompany->getCity(),
                    'PostalCode' => $agenceCompany->getZipCode(),
                    'State ' => 'France',
                    'ExternalID__c' => rand(1, 9999), #Id from Robusto
                    'Fax' => '0606060606', //Fax from Robusto Agence
                    'Extension' => $odigoInfos['odigoExtension'],
                    'OdigoCti__Odigo_login__c' => $odigoInfos['odigoExtension'],
                    'Telephone_interne__c' => $odigoInfos['redirectPhoneNumber'],
                    'Phone' => $odigoInfos['odigoPhoneNumber'],
                    'Title' => $this->fonctionManager->load($request->request->get('utilisateur')['fonction'])->getName(),
                    'Department' => $this->agenceManager->load($request->request->get('utilisateur')['agence'])->getNameInCompany(),
                    'Division' => $this->serviceManager->load($request->request->get('utilisateur')['service'])->getNameInCompany(),
                    //'UserPermissionsSupportUser' => $this->serviceCloudAccesManager->load($request->request->get('utilisateur')['fonction'])->getStatus(),
                )
            );
            try {
                $this->salesforceApiService->createNewUser($params, json_encode($newSalesforceUser));
                $this->fonctionManager->appendSessionMessaging(array('errorCode' => '0', 'message' => 'L\'Utilisateur '.$request->request->get('utilisateur')['email'].' a été créé dans Salesforce'));
            } catch (\Exception $e) {
                $this->fonctionManager->appendSessionMessaging(array('errorCode' => error_log($e->getMessage()), 'message' => $e->getMessage()));
            }
            $salesforceUserId = json_decode($this->salesforceApiService->getAccountByUsername($request->request->get('utilisateur')['email'], $params)['error'])->records[0]->Id;
            $this->salesforceApiGroupesService->addGroupesForNewUser($salesforceUserId, $request->request->get('utilisateur')['fonction'], $params);
            $this->salesforceApiTerritoriesService->addTerritoriesForNewUser($salesforceUserId, $request->request->get('utilisateur')['service'], $params);
        }
    }
}