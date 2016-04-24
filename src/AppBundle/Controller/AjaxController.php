<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Exception;

/**
 * Class AjaxController
 * @package AppBundle\Controller
 */
class AjaxController extends Controller
{
    /**
     * @param $service
     * @param $fonction
     * @Route(path="/ajax/check/odigo/isabletouse/{service}/{fonction}",name="ajax_able_use_odigo")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function isAbleToUseOdigo($service, $fonction)
    {
        if ($this->get('core.service_manager')->load($service)->getNameInOdigo() == "" || $this->get('core.fonction_manager')->load($fonction)->getNameInOdigo() == "") {
            return new JsonResponse(0);
        } else {
            return new JsonResponse(1);
        }
    }

    /**
     * @param $email
     * @Route(path="/ajax/check/google/isexist/{email}",name="ajax_exist_in_google")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function isExistGmailAccount($email)
    {
        try {
            return new JsonResponse($this->get('google.google_api_service')->getInfosFromEmail($this->get('google.google_api_service')->innitApi($this->getParameter('google_api')), $email, $this->getParameter('google_api')));
        } catch (Exception $e) {
            return new JsonResponse('nouser');
        }
    }

    /**
     * @Route(path="/ajax/get/credentials",name="ajax_get_credentials")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getCredentialsForSecurity()
    {
        $user = $this->get('fos_user.user_manager')->findUserByUsername($this->get('security.token_storage')->getToken()->getUser()->getUsername());
        return new JsonResponse(array('user' => $user->getUsername(), 'password' => $user->getPassword()));
    }

    /**
     * @param $userMail
     * @Route(path="/ajax/get/salesforce/utilisateur/{userMail}",name="ajax_get_salesforce_utilisateur")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getUserOnSalesforceByEmail($userMail)
    {
        return new JsonResponse($this->get('salesforce.salesforce_api_service')->getAccountByUsername($userMail, $this->getParameter('salesforce')));
    }

    /**
     * @Route(path="/ajax/get/salesforce/profiles",name="ajax_get_salesforce_profiles")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getSalesforceProfilesListe()
    {
        $finalTab = array();
        $i = 0;
        foreach ($this->get('salesforce.salesforceprofile_manager')->getStandardProfileListe() as $item) {
            $finalTab[$i] = array('id' => $item->getId(), 'profileId' => $item->getProfileId(), 'profileName' => $item->getProfileName(), 'userLicenseId' => $item->getUserLicenseId(), 'userType' => $item->getUserType());
            $i++;
        }
        return new JsonResponse($finalTab);
    }

    /**
     * @Route(path="/ajax/get/salesforce/groupes",name="ajax_get_salesforce_groupes")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getSalesforceGroupeListe()
    {
        $finalTab = array();
        $i = 0;
        foreach ($this->get('salesforce.salesforcegroupe_manager')->getStandardProfileListe() as $item) {
            $finalTab[$i] = array('id' => $item->getId(), 'groupeId' => $item->getGroupeId(), 'groupeName' => $item->getGroupeName());
            $i++;
        }
        return new JsonResponse($finalTab);
    }

    /**
     * @param $fonctionId
     * @Route(path="/ajax/get/salesforce/service_cloud/{fonctionId}",name="ajax_get_salesforce_service_cloud")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getSalesforceServiceCloudForFonction($fonctionId)
    {
        return new JsonResponse($this->get('salesforce.service_cloud_acces_manager')->createArray($fonctionId));
    }

    /**
     * @param $fonctionId
     * @Route(path="/ajax/get/salesforce/groupe_fonction/{fonctionId}",name="ajax_get_salesforce_groupe_fonction")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getSalesforceGroupeForFonction($fonctionId)
    {
        $groupesIds = $this->get('salesforce.groupe_to_fonction_manager')->createArray($fonctionId);
        $groupes = [];
        foreach ($groupesIds as $groupe)
        {
            $groupe = $this->get('salesforce.salesforcegroupe_manager')->load($groupe);
            $groupes[] = array('id' => $groupe->getId(), 'groupeName' => $groupe->getGroupeName());
        }
        return new JsonResponse($groupes);
    }
}