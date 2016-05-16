<?php
namespace DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class PhoneDashboardController extends Controller
{
    private $temp;

    private $stock;

    private $order;

    private $orangeKeys;

    private $iprosodie;

    /**
     * @param $listAprosodie
     * @param $odigonum
     * @param $finalTab1
     * @return mixed
     */
    private function foreachListAprosodie($listAprosodie, $odigonum, $finalTab1)
    {
        if (!isset($finalTab2[$odigonum['service_name'].'_'.$odigonum['fonction_name']])) {
            $finalTab2[$odigonum['service_name'].'_'.$odigonum['fonction_name']] = 0;
        }
        if ($odigonum['service_name'] == $this->temp) {
            $this->stock[str_replace("é", "e", str_replace("'", "", str_replace(' ', '_', $odigonum['fonction_name'])))] = array('full' => (int)$odigonum['nbnum'], 'used' => (int)$finalTab2[$odigonum['service_name'].'_'.$odigonum['fonction_name']], 'last' => (int)$odigonum['nbnum'] - (int)$finalTab2[$odigonum['service_name'].'_'.$odigonum['fonction_name']]);
        } else {
            if ($this->temp != '') {
                $finalTab1[$this->temp] = $this->stock;
            }
            $this->stock[str_replace("é", "e", str_replace("'", "", str_replace(' ', '_', $odigonum['fonction_name'])))] = array('full' => (int)$odigonum['nbnum'], 'used' => (int)$finalTab2[$odigonum['service_name'].'_'.$odigonum['fonction_name']], 'last' => (int)$odigonum['nbnum'] - (int)$finalTab2[$odigonum['service_name'].'_'.$odigonum['fonction_name']]);
        }
        $this->temp = $odigonum['service_name'];
        $this->iprosodie = $this->iprosodie + 1;
        if ($this->iprosodie == count($listAprosodie)) {
            $finalTab1[$this->temp] = $this->stock;
        }
        return $finalTab1;
    }


    /**
     * @param $listAprosodie
     * @param $listBprosodie
     * @return array
     */
    private function generateAgenceListNumeros($listAprosodie, $listBprosodie)
    {
        $this->iprosodie = 0;
        $finalTab1       = [];
        $finalTab2       = [];
        $this->temp      = '';
        $this->stock     = [];
        $this->order     = [];
        foreach ($listBprosodie as $odigonum2) {
            $finalTab2[$odigonum2['service_name'].'_'.$odigonum2['fonction_name']] = $odigonum2['nbnum'];
        }
        foreach ($listAprosodie as $odigonum) {
            $finalTab1 = $this->foreachListAprosodie($listAprosodie, $odigonum, $finalTab1);
        }
        return $finalTab1;
    }

    /**
     * @param $odigonum
     * @param $finalTab1
     * @return mixed
     */
    private function foreachListAorange($odigonum, $finalTab1, $finalTab2)
    {
        $this->orangeKeys[] = $odigonum['service_name'];
        if (!isset($finalTab2[$odigonum['service_name']])) {
            $finalTab2[$odigonum['service_name'].'_'.$odigonum['fonction_name']] = 0;
        }
        $finalTab1[$odigonum['service_name']] = array('full' => (int)$odigonum['nbnum'], 'used' => (int)$finalTab2[$odigonum['service_name']], 'last' => (int)$odigonum['nbnum'] - (int)$finalTab2[$odigonum['service_name']]);

        return $finalTab1;
    }

    /**
     * @param $listAorange
     * @param $listBorange
     * @return array
     */
    private function generateAgenceListNumerosOrange($listAorange, $listBorange)
    {
        $finalTab         = [];
        $finalTab1        = [];
        $finalTab2        = [];
        $full             = [];
        $used             = [];
        $last             = [];
        $this->orangeKeys = [];

        foreach ($listBorange as $odigonum2) {
            $finalTab2[$odigonum2['service_name']] = $odigonum2['nbnum'];
        }
        foreach ($listAorange as $odigonum) {
            $finalTab1 = $this->foreachListAorange($odigonum, $finalTab1, $finalTab2);
        }
        foreach ($finalTab1 as $key => $value) {
            $full[$key] = $value['full'];
            $used[$key] = $value['used'];
            $last[$key] = $value['last'];
        }
        $finalTab['full'] = $full;
        $finalTab['used'] = $used;
        $finalTab['last'] = $last;

        return $finalTab;
    }

    /**
     * @Route("/admin/phone_dashboard", name="phone_dashboard")
     */
    public function phoneDashboardAction()
    {
        $session_messaging = $this->get('session')->get('messaging');
        $this->get('session')->set('messaging', []);
        $globalAlertColor = $this->get('core.index.controller_service')->getGlobalAlertColor($session_messaging);
        $candidatListe = $this->get('core.candidat_manager')->getRepository()->findBy(array('isArchived' => '0'), array('startDate' => 'ASC'));

        return $this->render('DashboardBundle:Default:phone_dashboard.html.twig', array(
            'entity'                        => '',
            'nb_candidat'                   => count($candidatListe),
            'candidat_color'                => $this->get('core.index.controller_service')->colorForCandidatSlider($candidatListe[0]->getStartDate()->format("Y-m-d")),
            'session_messaging'             => $session_messaging,
            'currentUserInfos'              => $this->get('security.token_storage')->getToken()->getUser(),
            'userPhoto'                     => $this->get('google.google_user_api_service')->base64safeToBase64(stream_get_contents($this->get('security.token_storage')->getToken()->getUser()->getPhoto())),
            'globalAlertColor'              => $globalAlertColor,
            'remaining_gmail_licenses'      => $this->get('app.parameters_calls')->getParam('remaining_google_licenses'),
            'remaining_salesforce_licenses' => $this->get('app.parameters_calls')->getParam('remaining_licences_type_Salesforce'),
            'odigoNumfinalTabAgence'        => $this->generateAgenceListNumeros($this->get('odigo.odigotelliste_manager')->calculNumberOfNumeroByServiceForAgencies(), $this->get('odigo.odigotelliste_manager')->calculNumberOfNumeroByServiceInUseForAgencies()),
            'odigoNumfinalTabPFA'           => $this->generateAgenceListNumeros($this->get('odigo.odigotelliste_manager')->calculNumberOfNumeroByServiceForPFA(), $this->get('odigo.odigotelliste_manager')->calculNumberOfNumeroByServiceInUseForPFA()),
            'odigoNumfinalTabSSC'           => $this->generateAgenceListNumeros($this->get('odigo.odigotelliste_manager')->calculNumberOfNumeroByServiceForSSC(), $this->get('odigo.odigotelliste_manager')->calculNumberOfNumeroByServiceInUseForSSC()),
            'orangeNumfinalTab'             => $this->generateAgenceListNumerosOrange($this->get('odigo.orangetelliste_manager')->calculNumberOfNumeroByService(), $this->get('odigo.orangetelliste_manager')->calculNumberOfNumeroByServiceInUse()),
            'orangeKeys'                    => $this->orangeKeys,
        ));
    }
}
