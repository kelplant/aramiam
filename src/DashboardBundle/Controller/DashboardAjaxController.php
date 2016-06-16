<?php
namespace DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Exception;
use CoreBundle\Entity\Admin\Candidat;
use Doctrine\ORM\Query\ResultSetMapping;

/**
 * Class DashboardAjaxController
 * @package Dashboard\Controller
 */
class DashboardAjaxController extends Controller
{
    /**
     * @param $data
     * @return array
     */
    private function objectToArray($data)
    {
        if (is_array($data) || is_object($data)) {
            $result = [];

            foreach ($data as $key => $value) {
                $result[$key] = $this->objectToArray($value);
            }
            return $result;
        }
        return $data;
    }

    /**
     * @param $candidat
     * @return mixed
     */
    private function convertDatas($candidat)
    {
        $candidat['agence'] = $this->get('core.agence_manager')->load($candidat['agence'])->getName();
        $candidat['service'] = $this->get('core.service_manager')->load($candidat['service'])->getName();
        $candidat['fonction'] = $this->get('core.fonction_manager')->load($candidat['fonction'])->getName();
        $candidat['startDate'] = date('Y-m-d', strtotime($candidat['startDate']['date']));

        return $candidat;
    }

    /**
     * @return array
     */
    private function getCandidatDatas()
    {
        $result = $this->objectToArray($this->get('core.candidat_manager')->getRepository()->findBy(array('isArchived' => '0'), array('startDate' => 'DESC')));

        $finalDatas = [];

        foreach ($result as $candidat) {
            $finalDatas[] = $this->convertDatas($candidat);
        }

        return $finalDatas;
    }

    /**
     * @param $statusPoste
     * @param $a
     * @param $b
     * @return mixed
     */
    private function testForStatusPoste($statusPoste, $a, $b)
    {
        if ($statusPoste == 'Création') {
            return $a;
        } else {
            return $b;
        }
    }

    /**
     * @param $candidat
     * @return string
     */
    private function gimmeAColor($candidat)
    {
        if ($candidat['agence'] == 'Siège' && $candidat['service'] != 'Satisfaction Client') {
            return $this->testForStatusPoste($candidat['statusPoste'], '#ff9900', '#33cc33');
        } else {
            return $this->testForStatusPoste($candidat['statusPoste'], '#ff3300', '#33ccff');
        }
    }

    /**
     * @param $finalDatas
     * @return array
     */
    private function finalTable($finalDatas)
    {
        $finalTable = [];

        foreach ($finalDatas as $candidat) {

            $title           = $candidat['surname'].' '.$candidat['name'].' '.$candidat['service'];
            $start           = $candidat['startDate'];
            $color           = $this->gimmeAColor($candidat);
            $backgroundColor = $color;
            $borderColor     = $color;

            $finalTable[]    = array('title' => $title, 'start' => $start, 'backgroundColor' => $backgroundColor, 'borderColor' => $borderColor, 'id' => $candidat['id']);
        }

        return $finalTable;
    }

    /**
     * @Route(path="/ajax/dashboard/get/candidat_todo_liste",name="ajax_get_candidat_todo_liste")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getCandidatStartDates()
    {
        $finalDatas = $this->getCandidatDatas();
        $finalTable = $this->finalTable($finalDatas);

        return new JsonResponse($finalTable);
    }

    /**
     * @param $newMax
     * @Route(path="/ajax/dashboard/licences/gmail/update/maxnumber/{newMax}",name="ajax_update_dashboard_licences_gmail_maxnumber")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateGmailLicencesMaxNumber($newMax)
    {
        return new JsonResponse($this->get('app.parameters_calls')->setParamForName('max_google_licenses', $newMax, 'google_dashboard'));
    }

    /**
     * @Route(path="/ajax/dashboard/get/graph/utilisateur",name="ajax_get_graph_utilisateur")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getUtilisateurGraphInfos()
    {
        $result = $this->get('core.utilisateur_manager')
            ->executeRowQuery("SELECT weekofyear(p.start_date) as wk, year(p.start_date) as yr, count(*) as ct FROM core_admin_utilisateurs p WHERE year(p.start_date) >= year(now()) - 1 GROUP BY wk, yr ORDER BY yr ASC, wk ASC");

        $finalTab = [];

        foreach ($result as $item) {
            $finalTab[] = (object)array('y' =>$item['yr'].' W'.$item['wk'], 'item1' => (int)$item['ct']);
        }

        return new JsonResponse($finalTab);
    }
}