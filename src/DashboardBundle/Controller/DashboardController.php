<?php
namespace DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DashboardController extends Controller
{
    private $countNewUser;

    private $startDate;

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

        $finalTab = [];
        $countNewUser = 0;
        foreach ($result as $member) {
            $startDate = $member->getStartDate()->format('Y-m-d');
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
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $session_messaging = $this->get('session')->get('messaging');
        $this->get('session')->set('messaging', []);
        $candidatListe = $this->get('core.candidat_manager')->getRepository()->findBy(array('isArchived' => '0'), array('startDate' => 'ASC'));
        $lastest_users = $this->lastest_users();
        return $this->render('DashboardBundle:Default:dashboard.html.twig', array(
            'entity' => '',
            'nb_candidat' => count($candidatListe),
            'candidat_color' => $this->get('core.index.controller_service')->colorForCandidatSlider($candidatListe[0]->getStartDate()->format("Y-m-d")),
            'session_messaging' => $session_messaging,
            'currentUserInfos' => $this->get('security.token_storage')->getToken()->getUser(),
            'userPhoto' => $this->get('google.google_api_service')->base64safeToBase64(stream_get_contents($this->get('security.token_storage')->getToken()->getUser()->getPhoto())),
            'lastest_members' => $lastest_users['finalTab'],
            'countNewUser' => $lastest_users['countNewUser'],
        ));
    }
}
