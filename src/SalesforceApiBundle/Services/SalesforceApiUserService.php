<?php
namespace SalesforceApiBundle\Services;

use CoreBundle\Entity\Admin\Utilisateur;
use CoreBundle\Services\Manager\Admin\UtilisateurManager;
use SalesforceApiBundle\Entity\ApiObjects\SalesforceUser;
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

class SalesforceApiUserService extends AbstractSalesforceApiService
{
    /**
     * @var SalesforceUserFactory
     */
    protected $salesforceUserFactory;

    /**
     * @var ProsodieOdigoManager
     */
    protected $prosodieOdigo;

    /**
     * @var UtilisateurManager
     */
    protected $utilisateurManager;

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
     * @param SalesforceUserFactory $salesforceUserFactory
     * @param ProsodieOdigoManager $prosodieOdigo
     * @param UtilisateurManager $utilisateurManager
     * @param AgenceManager $agenceManager
     * @param ServiceManager $serviceManager
     * @param FonctionManager $fonctionManager
     * @param ParametersManager $parametersManager
     * @param AramisAgencyManager $aramisAgencyManager
     * @param SalesforceServiceCloudAccesManager $serviceCloudAccesManager
     * @param SalesforceApiGroupesServices $salesforceApiGroupesService
     * @param SalesforceApiTerritoriesServices $salesforceApiTerritoriesService
     */
    public function __construct(SalesforceUserFactory $salesforceUserFactory, ProsodieOdigoManager $prosodieOdigo, UtilisateurManager $utilisateurManager,AgenceManager $agenceManager, ServiceManager $serviceManager, FonctionManager $fonctionManager, ParametersManager $parametersManager, AramisAgencyManager $aramisAgencyManager, SalesforceServiceCloudAccesManager $serviceCloudAccesManager, SalesforceApiGroupesServices $salesforceApiGroupesService, SalesforceApiTerritoriesServices $salesforceApiTerritoriesService)
    {
        $this->salesforceUserFactory           = $salesforceUserFactory;
        $this->prosodieOdigo                   = $prosodieOdigo;
        $this->utilisateurManager              = $utilisateurManager;
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
     * @param $params
     * @param $newSalesforceUser
     * @return array|string
     */
    public function createNewUser($params, $newSalesforceUser)
    {
        return $this->executeQuery('/sobjects/User/', $params, $newSalesforceUser, "POST");
    }

    /**
     * @param $params
     * @param $newSalesforceUser
     * @return array|string
     */
    public function updateUser($params, $newSalesforceUser)
    {
        return $this->executeQuery('/sobjects/User/', $params, $newSalesforceUser, "POST");
    }

    /**
     * @param $emailToLook
     * @param $params
     * @return mixed
     */
    public function getAccountByUsername($emailToLook, $params)
    {
        $query = "SELECT Id,Username,CallCenterId FROM User WHERE Username = '".$emailToLook."'";
        return $this->executeQuery('/query?q='.urlencode($query), $params, null, "GET");
    }

    /**
     * @param $emailToLook
     * @param $params
     * @return array|string
     */
    public function getAllInfosForAccountByUsername($emailToLook, $params)
    {
        return $this->executeQuery('/sobjects/User/Username/'.$emailToLook, $params, null, "GET");
    }

    /**
     * @param $fonction
     * @param SalesforceUser $newSalesforceUser
     * @return mixed
     */
    private function checkForServiceCloud($fonction, SalesforceUser $newSalesforceUser)
    {
        $checkForPermissionToServiceCloud = $this->serviceCloudAccesManager->load($fonction);
        if (!is_null($checkForPermissionToServiceCloud) === true) {
            $newSalesforceUser->setUserPermissionsSupportUser($checkForPermissionToServiceCloud->getStatus());
        }
        return $newSalesforceUser;
    }

    /**
     * @param Request $request
     * @param Utilisateur $utilisateurInfos
     * @return mixed
     */
    private function prepareSalesforceUser(Request $request, Utilisateur $utilisateurInfos)
    {
        $paramsForSalesforceApi = $this->parametersManager->getAllAppParams('salesforce_api');
        $nickname = $this->shortNickName($utilisateurInfos->getName(), $utilisateurInfos->getSurname());
        $odigoInfos = $this->ifOdigoCreated($request->request->get('utilisateur')['isCreateInOdigo'], $paramsForSalesforceApi["salesforce_odigo_cti_id"]);
        $agenceCompany = $this->aramisAgencyManager->load($this->agenceManager->load($request->request->get('utilisateur')['agence'])->getNameInCompany());
        $newSalesforceUser = $this->salesforceUserFactory->createFromEntity(
            array(
                'Username'                              => $utilisateurInfos->getEmail(),
                'LastName'                              => $utilisateurInfos->getName(),
                'FirstName'                             => $utilisateurInfos->getSurname(),
                'Email'                                 => $utilisateurInfos->getEmail(),
                'TimeZoneSidKey'                        => 'Europe/Paris',
                'Alias'                                 => substr($nickname, 0, 8),
                'CommunityNickname'                     => $nickname."aramisauto",
                'IsActive'                              => true,
                'LocaleSidKey'                          => "fr_FR",
                'EmailEncodingKey'                      => "ISO-8859-1",
                'ProfileId'                             => $request->request->get('salesforce')['profile'],
                'LanguageLocaleKey'                     => "FR",
                'UserPermissionsMobileUser'             => true,
                'UserPreferencesDisableAutoSubForFeeds' => false,
                'CallCenterId'                          => $odigoInfos['callCenterId'],
                'Street'                                => $agenceCompany->getAddress1(),
                'City'                                  => $agenceCompany->getCity(),
                'PostalCode'                            => $agenceCompany->getZipCode(),
                'State '                                => 'France',
                'ExternalID__c'                         => rand(1, 9999), #Id from Robusto
                'Fax'                                   => '0606060606', //Fax from Robusto Agence
                'Extension'                             => $odigoInfos['odigoExtension'],
                'OdigoCti__Odigo_login__c'              => $odigoInfos['odigoExtension'],
                'Telephone_interne__c'                  => $odigoInfos['redirectPhoneNumber'],
                'Phone'                                 => $odigoInfos['odigoPhoneNumber'],
                'Title'                                 => $this->fonctionManager->load($utilisateurInfos->getFonction())->getName(),
                'Department'                            => $this->agenceManager->load($utilisateurInfos->getAgence())->getNameInCompany(),
                'Division'                              => $this->serviceManager->load($utilisateurInfos->getService())->getNameInCompany(),
            )
        );
        return $this->checkForServiceCloud($utilisateurInfos->getFonction(), $newSalesforceUser);
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
            $utilisateurInfos = $this->utilisateurManager->load($request->request->get('utilisateur')['id']);
            $newSalesforceUser = $this->prepareSalesforceUser($request, $utilisateurInfos);
            try {
                $this->createNewUser($params, json_encode($newSalesforceUser));
                $this->fonctionManager->appendSessionMessaging(array('errorCode' => '0', 'message' => 'L\'Utilisateur '.$utilisateurInfos->getEmail().' a été créé dans Salesforce'));
            } catch (\Exception $e) {
                $this->fonctionManager->appendSessionMessaging(array('errorCode' => error_log($e->getMessage()), 'message' => $e->getMessage()));
            }
            $salesforceUserId = json_decode($this->getAccountByUsername($utilisateurInfos->getEmail(), $params))->records[0]->Id;
            $this->salesforceApiGroupesService->addGroupesForNewUser($salesforceUserId, $utilisateurInfos->getFonction(), $params);
            $this->salesforceApiTerritoriesService->addTerritoriesForNewUser($salesforceUserId, $utilisateurInfos->getService(), $params);
        }
    }
}