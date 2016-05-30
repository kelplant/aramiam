<?php
namespace CoreBundle\Controller\User;

use CoreBundle\Entity\Admin\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class ProfileController
 * @package CoreBundle\Controller\User
 */
class ProfileController extends Controller
{

    /**
     * @param $odigoLinkNumber
     * @return null|object
     */
    private function checkAndGetOdigoInfos($odigoLinkNumber)
    {
        if ($odigoLinkNumber != null && $odigoLinkNumber != 0)
        {
           return $this->get('odigo.prosodie_odigo_manager')->load($odigoLinkNumber);
        }
    }

    /**
     * @param $myProfil
     * @return \Google_Service_Directory_User
     */
    private function checkAndGetGmailInfos($myProfil)
    {
        if ($myProfil->getIsCreateInGmail() != null && $myProfil->getIsCreateInGmail() != 0)
        {
            return $this->get('google.google_user_api_service')->getInfosFromEmail($this->get('google.google_user_api_service')->innitApi($this->getParameter('google_api')), $myProfil->getEmail(), $this->getParameter('google_api'));
        }
    }

    /**
     * @param $activeDirectoryLinkUser
     * @return null|object
     */
    private function checkAndGetActiveDirectoryInfos($activeDirectoryLinkUser)
    {
        if ($activeDirectoryLinkUser != null && $activeDirectoryLinkUser != '0')
        {
            echo 'coucou';
            return $this->get('ad.active_directory_user_link_manager')->load($activeDirectoryLinkUser);
        }
    }

    /**
     * @param $robustoLinkUser
     * @return null|object
     */
    private function checkAndGetRobustoInfos($robustoLinkUser)
    {
        if ($robustoLinkUser != null && $robustoLinkUser != 0)
        {
            return $this->get('aramis.aramis_user_link')->load($robustoLinkUser);
        }
    }

    /**
     * @param $groupListFromSalesforce
     * @return array|null
     */
    private function checkAndGetSalesforceGroupsInfos($groupListFromSalesforce)
    {
        if (is_array($groupListFromSalesforce) == true) {
            return null;
        } else if ($groupListFromSalesforce->totalSize != 0) {
            $finaleGroupeListFromSalesforce = [];
            foreach ($groupListFromSalesforce->records as $groupe) {
                $finalgroup = $this->get('salesforce.salesforcegroupe_manager')->load($groupe->GroupId);
                $finaleGroupeListFromSalesforce[] = $finalgroup->getGroupeName();
            }
            return $finaleGroupeListFromSalesforce;
        } else {
            return null;
        }
    }

    /**
     * @param $territoryListFromSalesforce
     * @return array|null
     */
    private function checkAndGetSalesforceTerritoriesInfos($territoryListFromSalesforce)
    {
        if (is_array($territoryListFromSalesforce) == true) {
            return null;
        } else if ($territoryListFromSalesforce->totalSize != 0) {
            $finaleTerritoryListFromSalesforce = [];
            foreach ($territoryListFromSalesforce->records as $territory) {
                $finalgroup = $this->get('salesforce.salesforceterritory_manager')->load($territory->TerritoryId);
                $finaleTerritoryListFromSalesforce[] = $finalgroup->getTerritoryName();
            }
            return $finaleTerritoryListFromSalesforce;
        } else {
            return null;
        }
    }

    /**
     * @param $myProfil
     * @return array
     */
    private function checkAndGetSalesforceInfos($myProfil)
    {
        if ($myProfil->getIsCreateInSalesforce() != null && $myProfil->getIsCreateInSalesforce() != 0)
        {
            $generalSalesforceInfos = json_decode($this->get('salesforce.salesforce_api_user_service')->getAllInfosForAccountByUsername($myProfil->getEmail(), $this->getParameter('salesforce')));
            $groupListFromSalesforce = json_decode($this->get('salesforce.salesforce_api_groupes_services')->getListOfGroupesForUser($this->getParameter('salesforce'), $myProfil->getIsCreateInSalesforce()));
            $territoryListFromSalesforce = json_decode($this->get('salesforce.salesforce_api_territories_services')->getListOfTerritoriesForUser($this->getParameter('salesforce'), $myProfil->getIsCreateInSalesforce()));

            return array('generales' => $generalSalesforceInfos, 'groups' => $this->checkAndGetSalesforceGroupsInfos($groupListFromSalesforce), 'territories' => $this->checkAndGetSalesforceTerritoriesInfos($territoryListFromSalesforce));
        }

    }

    /**
     * @Route(path="/user/profile/show/{panel}", name="user_profile_show")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showProfileAction($panel)
    {
        $session_messaging = $this->get('session')->get('messaging');
        $this->get('session')->set('messaging', []);
        $globalAlertColor = $this->get('core.index.controller_service')->getGlobalAlertColor($session_messaging);
        $candidatListe = $this->get('core.candidat_manager')->getRepository()->findBy(array('isArchived' => '0'), array('startDate' => 'ASC'));

        $userInfos = $this->get('security.token_storage')->getToken()->getUser();
        $myProfil = $this->get('core.utilisateur_manager')->load($this->get('ad.active_directory_user_link_manager')->getRepository()->findOneByIdentifiant($userInfos->getUsername())->getUser());
        $formEdit = $this->createForm('CoreBundle\Form\Admin\UtilisateurType', $myProfil, array('allow_extra_fields' => $this->get('core.index.controller_service')->generateListeChoices()));

        return $this->render('CoreBundle:User/Profile:ProfileShow.html.twig', array(
            'gmailInfos'                    => $this->checkAndGetGmailInfos($myProfil),
            'salesforceInfos'               => $this->checkAndGetSalesforceInfos($myProfil),
            'activeDirectoryInfos'          => $this->checkAndGetActiveDirectoryInfos($myProfil->getIsCreateInWindows()),
            'aramisInfos'                   => $this->checkAndGetRobustoInfos($myProfil->getIsCreateInRobusto()),
            'odigoInfos'                    => $this->checkAndGetOdigoInfos($myProfil->getIsCreateInOdigo()),
            'panel'                         => $panel,
            'entity'                        => '',
            'nb_candidat'                   => count($candidatListe),
            'candidat_color'                => $this->get('core.index.controller_service')->colorForCandidatSlider($candidatListe[0]->getStartDate()->format("Y-m-d")),
            'session_messaging'             => $session_messaging,
            'formEdit'                      => $formEdit->createView(),
            'currentUserInfos'              => $userInfos,
            'userPhoto'                     => $this->get('google.google_user_api_service')->base64safeToBase64(stream_get_contents($userInfos->getPhoto())),
            'globalAlertColor'              => $globalAlertColor,
            'myProfil'                      => $myProfil,
            'remaining_gmail_licenses'      => $this->get('app.parameters_calls')->getParam('remaining_google_licenses'),
            'remaining_salesforce_licenses' => $this->get('app.parameters_calls')->getParam('remaining_licences_type_Salesforce'),
        ));
    }
}