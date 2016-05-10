<?php
namespace SalesforceApiBundle\Factory;

use AppBundle\Factory\AbstractFactory;
use AppBundle\Services\Manager\ParametersManager;
use AramisApiBundle\Services\Manager\AramisAgencyManager;
use CoreBundle\Entity\Admin\Utilisateur;
use CoreBundle\Services\Manager\Admin\AgenceManager;
use CoreBundle\Services\Manager\Admin\FonctionManager;
use CoreBundle\Services\Manager\Admin\ServiceManager;
use OdigoApiBundle\Services\Manager\ProsodieOdigoManager;
use SalesforceApiBundle\Entity\ApiObjects\SalesforceUser;
use Doctrine\Common\Util\Inflector;
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
     * @param Request $request
     * @param Utilisateur $utilisateurInfos
     * @return SalesforceUser
     */
    public function prepareSalesforceUser(Request $request, Utilisateur $utilisateurInfos)
    {
        $paramsForSalesforceApi = $this->parametersManager->getAllAppParams('salesforce_api');
        $nickname = $this->shortNickName($utilisateurInfos->getName(), $utilisateurInfos->getSurname());
        $odigoInfos = $this->ifOdigoCreated($request->request->get('utilisateur')['isCreateInOdigo'], $paramsForSalesforceApi["salesforce_odigo_cti_id"]);
        $agenceCompany = $this->aramisAgencyManager->load($this->agenceManager->load($request->request->get('utilisateur')['agence'])->getNameInCompany());
        $newSalesforceUser = $this->createFromEntity(
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