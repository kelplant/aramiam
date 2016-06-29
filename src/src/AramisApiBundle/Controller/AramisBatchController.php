<?php
namespace AramisApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use GuzzleHttp;

/**
 * Class AramisBatchController
 * @package AramisApiBundle\Controller
 */
class AramisBatchController extends Controller
{
    /**
     * @Route(path="/batch/insert/agencies",name="ajax_insert_agencies")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loadAgenciesFromAramis()
    {
        $this->get('aramis.aramisagency_manager')->truncateTable();
        $client = new GuzzleHttp\Client();
        $res = $client->request('GET', $this->getParameter('aramis_api')['ws_agency_url'], [
            'headers' => [
                'Accept' => 'application/json',
                'Content-type' => 'application/json',
            ]
        ]);
        foreach (json_decode($res->getBody()) as $agence) {
            $addAgency = $this->get('aramis.factory.aramis_agency')->createFromEntity($agence);
            if (!is_null($addAgency->getId()) && $addAgency->getId() != "00") {
                $this->get('core.agence_manager')->save($addAgency);
            } else {
                $this->get('core.agence_manager')->flush();
            }
        }
        return new JsonResponse($res->getBody());
    }
}