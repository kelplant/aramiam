<?php
namespace SalesforceApiBundle\Factory;

use AppBundle\Factory\AbstractFactory;
use AppBundle\Services\Manager\ParametersManager;
use AramisApiBundle\Entity\AramisAgency;
use AramisApiBundle\Services\Manager\AramisAgencyManager;
use CoreBundle\Entity\Admin\Utilisateur;
use CoreBundle\Services\Manager\Admin\AgenceManager;
use CoreBundle\Services\Manager\Admin\FonctionManager;
use CoreBundle\Services\Manager\Admin\ServiceManager;
use OdigoApiBundle\Services\Manager\ProsodieOdigoManager;
use SalesforceApiBundle\Entity\ApiObjects\SalesforceUser;
use Doctrine\Common\Util\Inflector;
use SalesforceApiBundle\Entity\SalesforceUserLink;
use SalesforceApiBundle\Services\Manager\SalesforceServiceCloudAccesManager;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SalesforceUserFactory
 * @package SalesforceApiBundle\Factory
 */
class SalesforceUserFactory extends AbstractFactory
{
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
     * @var array
     */
    private $odigoInfos;

    /**
     * @var AramisAgency
     */
    private $agenceCompany;

    /**
     * SalesforceApiUserService constructor.
     * @param ProsodieOdigoManager $prosodieOdigo
     * @param AgenceManager $agenceManager
     * @param ServiceManager $serviceManager
     * @param FonctionManager $fonctionManager
     * @param ParametersManager $parametersManager
     * @param AramisAgencyManager $aramisAgencyManager
     * @param SalesforceServiceCloudAccesManager $serviceCloudAccesManager
     */
    public function __construct(ProsodieOdigoManager $prosodieOdigo, AgenceManager $agenceManager, ServiceManager $serviceManager, FonctionManager $fonctionManager, ParametersManager $parametersManager, AramisAgencyManager $aramisAgencyManager, SalesforceServiceCloudAccesManager $serviceCloudAccesManager)
    {
        $this->prosodieOdigo                   = $prosodieOdigo;
        $this->agenceManager                   = $agenceManager;
        $this->serviceManager                  = $serviceManager;
        $this->fonctionManager                 = $fonctionManager;
        $this->parametersManager               = $parametersManager;
        $this->aramisAgencyManager             = $aramisAgencyManager;
        $this->serviceCloudAccesManager        = $serviceCloudAccesManager;
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
     * @param $utilisateurInfos
     * @param Request $request
     * @param $odigoInfos
     * @param $agenceCompany
     * @return SalesforceUser
     */
    private function createUserWithBDDDatas($utilisateurInfos, Request $request, $odigoInfos, $agenceCompany, $salesforceProfil)
    {
        $nickname = $this->shortNickName($utilisateurInfos->getName(), $utilisateurInfos->getSurname());
        return $this->createFromEntity(
            array(
                'Username'          => $utilisateurInfos->getEmail(),
                'LastName'          => $utilisateurInfos->getName(),
                'FirstName'         => $utilisateurInfos->getSurname(),
                'Email'             => $utilisateurInfos->getEmail(),
                'TimeZoneSidKey'    => 'Europe/Paris', 'Alias' => substr($nickname, 0, 8), 'CommunityNickname' => $nickname."aramisauto", 'IsActive' => true, 'LocaleSidKey' => "fr_FR", 'EmailEncodingKey' => "ISO-8859-1",
                'ProfileId'         => $salesforceProfil,
                'LanguageLocaleKey' => "FR", 'UserPermissionsMobileUser' => true, 'UserPreferencesDisableAutoSubForFeeds' => false,
                'Street'            => $agenceCompany->getAddress1(), 'City' => $agenceCompany->getCity(), 'PostalCode' => $agenceCompany->getZipCode(), 'State ' => 'France',
                'ExternalID__c'     => rand(1, 9999), #Id from Robusto
                'Fax'               => '0606060606', //Fax from Robusto Agence
                'Extension'         => $odigoInfos['odigoExtension'], 'OdigoCti__Odigo_login__c' => $odigoInfos['odigoExtension'], 'Telephone_interne__c' => $odigoInfos['redirectPhoneNumber'], 'Phone' => $odigoInfos['odigoPhoneNumber'], 'CallCenterId' => $odigoInfos['callCenterId'],
                'Title'             => $this->fonctionManager->load($utilisateurInfos->getFonction())->getName(),
                'Department'        => $this->agenceManager->load($utilisateurInfos->getAgence())->getNameInCompany(),
                'Division'          => $this->serviceManager->load($utilisateurInfos->getService())->getNameInCompany(),
            )
        );
    }

    /**
     * @param $tabToSend
     * @param $odigoInfos
     * @param $agenceCompany
     * @param SalesforceUserLink $salesforceUserInfos
     * @return SalesforceUser
     */
    private function createUserWithRequestDatas($tabToSend, $odigoInfos, $agenceCompany, SalesforceUserLink $salesforceUserInfos)
    {
        $nickname = $this->shortNickName($tabToSend['newDatas']['sn'], $tabToSend['newDatas']['givenName']);
        return $this->createFromEntity(
            array(
                'Username'          => $tabToSend['newDatas']['mail'],
                'LastName'          => $tabToSend['newDatas']['sn'],
                'FirstName'         => $tabToSend['newDatas']['givenName'],
                'Email'             => $tabToSend['newDatas']['mail'],
                'TimeZoneSidKey'    => 'Europe/Paris', 'Alias' => substr($nickname, 0, 8), 'CommunityNickname' => $nickname."aramisauto", 'IsActive' => true, 'LocaleSidKey' => "fr_FR", 'EmailEncodingKey' => "ISO-8859-1", 'LanguageLocaleKey' => "FR", 'UserPermissionsMobileUser' => true, 'UserPreferencesDisableAutoSubForFeeds' => false,
                'ProfileId'         => $salesforceUserInfos->getSalesforceProfil(),
                'Street'            => $agenceCompany->getAddress1(), 'City' => $agenceCompany->getCity(), 'PostalCode' => $agenceCompany->getZipCode(), 'State ' => 'France',
                'ExternalID__c'     => rand(1, 9999), #Id from Robusto
                'Fax'               => '0606060606', //Fax from Robusto Agence
                'Extension'         => $odigoInfos['odigoExtension'], 'OdigoCti__Odigo_login__c' => $odigoInfos['odigoExtension'], 'Telephone_interne__c' => $odigoInfos['redirectPhoneNumber'], 'Phone' => $odigoInfos['odigoPhoneNumber'], 'CallCenterId' => $odigoInfos['callCenterId'],
                'Title'             => $this->fonctionManager->load($tabToSend['request']->request->get('utilisateur')['fonction'])->getName(),
                'Department'        => $this->agenceManager->load($tabToSend['request']->request->get('utilisateur')['agence'])->getNameInCompany(),
                'Division'          => $this->serviceManager->load($tabToSend['request']->request->get('utilisateur')['service'])->getNameInCompany(),
            )
        );
    }
    /**
     * @param Request $request
     * @return $this
     */
    private function setDatasForUser(Request $request)
    {
        $paramsForSalesforceApi = $this->parametersManager->getAllAppParams('salesforce_api');

        $this->odigoInfos = $this->ifOdigoCreated($request->request->get('utilisateur')['isCreateInOdigo'], $paramsForSalesforceApi["salesforce_odigo_cti_id"]);
        $this->agenceCompany = $this->aramisAgencyManager->load($this->agenceManager->load($request->request->get('utilisateur')['agence'])->getNameInCompany());
        return $this;
    }

    /**
     * @param Request $request
     * @param Utilisateur $utilisateurInfos
     * @return SalesforceUser
     */
    public function prepareSalesforceUserFromBDD(Request $request, Utilisateur $utilisateurInfos, $salesforceProfil)
    {
        $this->setDatasForUser($request);
        $newSalesforceUser = $this->createUserWithBDDDatas($utilisateurInfos, $request, $this->odigoInfos, $this->agenceCompany, $salesforceProfil);

        return $this->checkForServiceCloud($utilisateurInfos->getFonction(), $newSalesforceUser);
    }

    /**
     * @param $tabToSend
     * @param SalesforceUserLink $salesforceUserInfos
     * @return SalesforceUser
     */
    public function prepareSalesforceUserFromRequest($tabToSend, SalesforceUserLink $salesforceUserInfos)
    {
        $this->setDatasForUser($tabToSend['request']);
        $newSalesforceUser = $this->createUserWithRequestDatas($tabToSend, $this->odigoInfos, $this->agenceCompany, $salesforceUserInfos);

        return $this->checkForServiceCloud($tabToSend['utilisateurFonction'], $newSalesforceUser);
    }

    /**
     * @param $userInfos
     * @return SalesforceUser
     */
    public function createFromEntity($userInfos)
    {
        $newSalesforceUser = new SalesforceUser();
        foreach ($userInfos as  $key => $value) {
            if ($value != "") {
                $newSalesforceUser->{"set".Inflector::camelize($key)}($value);
            }
        }

        return $newSalesforceUser;
    }
}