<?php
namespace OdigoApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use GuzzleHttp;

/**
 * Class OdigoBatchController
 * @package OdigoApiBundle\Controller
 */
class OdigoBatchController extends Controller
{
     /**
     * @param $lineToInsert
     * @Route(path="/ajax/insert/odigo/{lineToInsert}",name="ajax_insert_odigo_number")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addOdigoNumberViaFiles($lineToInsert)
    {
        $explodedTab = array();
        $explodedTab[] = explode(";", $lineToInsert);
        return new JsonResponse($this->get('odigo.odigotelliste_manager')->addFromApi($explodedTab[0][0], $this->get('core.service_manager')->returnIdFromOdigoName($explodedTab[0][1]), $this->get('core.fonction_manager')->returnIdFromOdigoName($explodedTab[0][2])));
    }

    /**
     * @param $lineToInsert
     * @Route(path="/ajax/insert/orange/{lineToInsert}",name="ajax_insert_orange_number")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addOrangeNumberViaFiles($lineToInsert)
    {
        $explodedTab = array();
        $explodedTab[] = explode(";", $lineToInsert);
        return new JsonResponse($this->get('odigo.orangetelliste_manager')->addFromApi($explodedTab[0][0], $this->get('core.service_manager')->returnIdFromOdigoName($explodedTab[0][1])));
    }
}