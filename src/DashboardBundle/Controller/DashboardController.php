<?php
namespace DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use DashboardBundle\Entity\DashboardTodoListEvent;

class DashboardController extends Controller
{
    private $startDate;

    private $temp;

    private $stock;

    private $order;

    private $orangeKeys;

    /**
     * @param $startDate
     * @return string
     */
    private function ifToday($startDate)
    {
        if ($startDate == date('Y-m-d')) {
            $this->startDate = 'Aujourd\'hui';
        }
    }

    /**
     * @param $startDate
     * @return string
     */
    private function ifHier($startDate)
    {
        if ($startDate == date('Y-m-d', time() - 24 * 60 * 60)) {
            $this->startDate = 'Hier';
        }
    }

    /**
     * @param $startDate
     * @return string
     */
    private function ifNotTodayOrHier($startDate)
    {
        if ($startDate < date('Y-m-d', time() - 24 * 60 * 60)) {
            $this->startDate = date('d M', strtotime($startDate));
        }
    }

    /**
     * @param $startDate
     * @param $countNewUser
     * @return mixed
     */
    private function countNewUser($startDate, $countNewUser)
    {
        if (date('Y-m-d', time() - 7 * 24 * 60 * 60) <= $startDate) {
            return $countNewUser + 1;
        } else {
            return $countNewUser;
        }
    }

    /**
     * @return array
     */
    private function lastest_users()
    {
        $result = $this->get('core.utilisateur_manager')->getRepository()->createQueryBuilder('p')
            ->where('p.isArchived = :isArchived')->addOrderBy('p.startDate', 'DESC')->setParameter('isArchived', 0)->setMaxResults('8')
            ->getQuery()->getResult();

        $finalTab     = [];
        $countNewUser = 0;

        foreach ($result as $member) {
            $startDate    = $member->getStartDate()->format('Y-m-d');
            $countNewUser = $this->countNewUser($startDate, $countNewUser);
            $this->ifToday($startDate);
            $this->ifHier($startDate);
            $this->ifNotTodayOrHier($startDate);
            $finalTab[] = array('viewName' => $member->getViewName(), 'id' => $member->getId(), 'startDate' => $this->startDate);
        }

        $finalTab = array('countNewUser' => $countNewUser, 'finalTab' => $finalTab);

        return $finalTab;
    }

    /**
     * @param $delais
     * @return string
     */
    private function gimmeColorForDelais($delais) {
        if ($delais <= 1) {
            return 'label-success';
        } elseif ($delais > 1 && $delais < 7) {
            return 'label-warning';
        } else {
            return 'label-danger';
        }
    }

    /**
     * @return array
     */
    private function prepareTodoListEvents()
    {
        $finalTodoListEvents = [];

        $todoListEvents = $this->get('dashboard.todo_list_manager')->getRepository()->findBy(array('isDone' => false), array('createDate' => 'DESC'));

        foreach ($todoListEvents as $event) {
            $delais                = round(($delais = strtotime(date('Y-m-d', time())) - strtotime($event->getCreateDate()->format('Y-m-d'))) / 86400);
            $finalTodoListEvents[] = array('delais' => $delais, 'color' => $this->gimmeColorForDelais($delais), 'id' => $event->getId(), 'name' => $event->getName(), 'comment' => $event->getComment(), 'createDate' => date('Y-m-d', strtotime($event->getCreateDate()->format('Y-m-d'))), 'isDone' => $event->getIsDone());
        }
        return $finalTodoListEvents;
    }

    /**
     * @Route("/", name="homepage_dashboard")
     */
    public function indexAction()
    {
        $session_messaging = $this->get('session')->get('messaging');
        $this->get('session')->set('messaging', []);
        $globalAlertColor = $this->get('core.index.controller_service')->getGlobalAlertColor($session_messaging);

        $candidatListe  = $this->get('core.candidat_manager')->getRepository()->findBy(array('isArchived' => '0'), array('startDate' => 'ASC'));
        $lastest_users  = $this->lastest_users();
        $todoListEvents = $this->prepareTodoListEvents();

        return $this->render('DashboardBundle:Default:dashboard.html.twig', array(
            'entity'            => '',
            'nb_candidat'       => count($candidatListe),
            'candidat_color'    => $this->get('core.index.controller_service')->colorForCandidatSlider($candidatListe[0]->getStartDate()->format("Y-m-d")),
            'session_messaging' => $session_messaging,
            'currentUserInfos'  => $this->get('security.token_storage')->getToken()->getUser(),
            'userPhoto'         => $this->get('google.google_user_api_service')->base64safeToBase64(stream_get_contents($this->get('security.token_storage')->getToken()->getUser()->getPhoto())),
            'lastest_members'   => $lastest_users['finalTab'],
            'countNewUser'      => $lastest_users['countNewUser'],
            'todoListEvents'    => $todoListEvents,
            'globalAlertColor'  => $globalAlertColor,
        ));
    }

    /**
     * @param $listA
     * @param $listB
     * @return array
     */
    private function generateAgenceListNumeros($listA, $listB)
    {
        $i           = 0;
        $finalTab1   = [];
        $finalTab2   = [];
        $this->temp  = '';
        $this->stock = [];
        $this->order = [];
        foreach ($listB as $odigonum2) {
            $finalTab2[$odigonum2['service_name'].'_'.$odigonum2['fonction_name']] = $odigonum2['nbnum'];
        }
        foreach ($listA as $odigonum) {
            if (!isset($finalTab2[$odigonum['service_name'].'_'.$odigonum['fonction_name']])) {
                $finalTab2[$odigonum['service_name'].'_'.$odigonum['fonction_name']] = 0;
            }
            if ($odigonum['service_name'] == $this->temp) {
                $this->stock[str_replace("é", "e", str_replace("'", "", str_replace(' ', '_', $odigonum['fonction_name'])))] = array('full' => (int)$odigonum['nbnum'], 'used' => (int)$finalTab2[$odigonum['service_name'].'_'.$odigonum['fonction_name']], 'last' => (int)$odigonum['nbnum'] - (int)$finalTab2[$odigonum['service_name'].'_'.$odigonum['fonction_name']]);
            } else {
                if ($this->temp != '') {
                    $finalTab1[$this->temp] = $this->stock;
                }
                $this->stock[str_replace("é", "e", str_replace("'", "", str_replace(' ','_',$odigonum['fonction_name'])))] = array('full' => (int)$odigonum['nbnum'], 'used' => (int)$finalTab2[$odigonum['service_name'].'_'.$odigonum['fonction_name']], 'last' => (int)$odigonum['nbnum'] - (int)$finalTab2[$odigonum['service_name'].'_'.$odigonum['fonction_name']]);
            }
            $this->temp = $odigonum['service_name'];
            $i = $i + 1;
            if($i == count($listA)) {
                $finalTab1[$this->temp] = $this->stock;
            }
        }
        return $finalTab1;
    }

    /**
     * @param $listA
     * @param $listB
     * @return array
     */
    private function generateAgenceListNumerosOrange($listA, $listB)
    {
        $finalTab         = [];
        $finalTab1        = [];
        $finalTab2        = [];
        $full             = [];
        $used             = [];
        $last             = [];
        $this->orangeKeys = [];

        foreach ($listB as $odigonum2) {
            $finalTab2[$odigonum2['service_name']] = $odigonum2['nbnum'];
        }
        foreach ($listA as $odigonum) {
            $this->orangeKeys[] = $odigonum['service_name'];
            if (!isset($finalTab2[$odigonum['service_name']])) {
                $finalTab2[$odigonum['service_name'].'_'.$odigonum['fonction_name']] = 0;
            }
            $finalTab1[$odigonum['service_name']] = array('full' => (int)$odigonum['nbnum'], 'used' => (int)$finalTab2[$odigonum['service_name']], 'last' => (int)$odigonum['nbnum'] - (int)$finalTab2[$odigonum['service_name']]);
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
        $candidatListe  = $this->get('core.candidat_manager')->getRepository()->findBy(array('isArchived' => '0'), array('startDate' => 'ASC'));

        return $this->render('DashboardBundle:Default:phone_dashboard.html.twig', array(
            'entity'                 => '',
            'nb_candidat'            => count($candidatListe),
            'candidat_color'         => $this->get('core.index.controller_service')->colorForCandidatSlider($candidatListe[0]->getStartDate()->format("Y-m-d")),
            'session_messaging'      => $session_messaging,
            'currentUserInfos'       => $this->get('security.token_storage')->getToken()->getUser(),
            'userPhoto'              => $this->get('google.google_user_api_service')->base64safeToBase64(stream_get_contents($this->get('security.token_storage')->getToken()->getUser()->getPhoto())),
            'globalAlertColor'       => $globalAlertColor,
            'odigoNumfinalTabAgence' => $this->generateAgenceListNumeros($this->get('odigo.odigotelliste_manager')->calculNumberOfNumeroByServiceForAgencies(), $this->get('odigo.odigotelliste_manager')->calculNumberOfNumeroByServiceInUseForAgencies()),
            'odigoNumfinalTabPFA'    => $this->generateAgenceListNumeros($this->get('odigo.odigotelliste_manager')->calculNumberOfNumeroByServiceForPFA(), $this->get('odigo.odigotelliste_manager')->calculNumberOfNumeroByServiceInUseForPFA()),
            'odigoNumfinalTabSSC'    => $this->generateAgenceListNumeros($this->get('odigo.odigotelliste_manager')->calculNumberOfNumeroByServiceForSSC(), $this->get('odigo.odigotelliste_manager')->calculNumberOfNumeroByServiceInUseForSSC()),
            'orangeNumfinalTab'      => $this->generateAgenceListNumerosOrange($this->get('odigo.orangetelliste_manager')->calculNumberOfNumeroByService(), $this->get('odigo.orangetelliste_manager')->calculNumberOfNumeroByServiceInUse()),
            'orangeKeys'             => $this->orangeKeys,
        ));
    }

    /**
     * @Route("/admin/licences", name="licences_dashboard")
     */
    public function licensesAction()
    {
        $session_messaging = $this->get('session')->get('messaging');
        $this->get('session')->set('messaging', []);
        $globalAlertColor = $this->get('core.index.controller_service')->getGlobalAlertColor($session_messaging);
        $candidatListe  = $this->get('core.candidat_manager')->getRepository()->findBy(array('isArchived' => '0'), array('startDate' => 'ASC'));

        return $this->render('DashboardBundle:Default:licenses.html.twig', array(
            'entity'                        => '',
            'nb_candidat'                   => count($candidatListe),
            'candidat_color'                => $this->get('core.index.controller_service')->colorForCandidatSlider($candidatListe[0]->getStartDate()->format("Y-m-d")),
            'session_messaging'             => $session_messaging,
            'currentUserInfos'              => $this->get('security.token_storage')->getToken()->getUser(),
            'userPhoto'                     => $this->get('google.google_user_api_service')->base64safeToBase64(stream_get_contents($this->get('security.token_storage')->getToken()->getUser()->getPhoto())),
            'globalAlertColor'              => $globalAlertColor,
            'salesforceLicenses'            => json_decode($this->get('salesforce.salesforce_api_user_service')->getLiencesInformations($this->getParameter('salesforce')))->records,
            'actualNumberGmailUserLicenses' => $this->get('google.google_user_api_service')->numberGmailUsers(null, $this->getParameter('google_api')),
            'maxNumberGmailUserLicenses'    => $this->get('app.parameters_calls')->getParam('max_google_licenses'),
        ));
    }
}
