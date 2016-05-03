<?php
namespace DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Exception;
use CoreBundle\Entity\Admin\Candidat;

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
            $result = array();
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
        $finalDatas = array();
        $result = $this->objectToArray($this->get('core.candidat_manager')->getRepository()->findBy(array('isArchived' => '0'), array('startDate' => 'DESC')));
        foreach ($result as $candidat) {
            $finalDatas[] = $this->convertDatas($candidat);
        }
        return $finalDatas;
    }

    private function gimmeAColor($candidat)
    {
        if ($candidat['agence'] == 'Siège' && $candidat['service'] != 'Satisfaction Client') {
            if ($candidat['statusPoste'] == 'Création') {
                return '#ff9900';
            } else {
                return '#33cc33';
            }
        } else {
            if ($candidat['statusPoste'] == 'Création') {
                return '#ff3300';
            } else {
                return '#33ccff';
            }
        }

    }

    /**
     * @param $finalDatas
     * @return array
     */
    private function finalTable($finalDatas)
    {
        $finalTable = array();
        foreach ($finalDatas as $candidat) {
            $title = $candidat['surname'].' '.$candidat['name'].' '.$candidat['service'];
            $start = $candidat['startDate'];
            $color = $this->gimmeAColor($candidat);
            $backgroundColor = $color;
            $borderColor = $color;
            $finalTable[] = array('title' => $title, 'start' => $start, 'backgroundColor' => $backgroundColor, 'borderColor' => $borderColor, 'id' => $candidat['id']);
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
}