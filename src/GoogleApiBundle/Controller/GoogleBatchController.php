<?php
namespace GoogleApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use GuzzleHttp;

/**
 * Class GoogleBatchController
 * @package GoogleApiBundle\Controller
 */
class GoogleBatchController extends Controller
{
    /**
     * @Route(path="/batch/google/groupe/reload/{login}/{password}",name="batch_google_groupes")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function reloadActiveDirectoryGroupeTable($login, $password)
    {
        if ($this->get('app.security.acces_service')->validateUser($login, $password) === true)
        {
            $this->get('google.google_group_manager')->truncateTable();
            $response = $this->get('google.google_api_service')->getListeOfGroupes($this->getParameter('google_api'));
            foreach ((array)$response->getGroups() as $record) {
                $this->get('google.google_group_manager')->add(array('id' => $record->getId(), 'name' => $record->getName(), 'email' => $record->getEmail()));
            }
            return $this->render("GoogleApiBundle:Batch:succes.html.twig");
        } else {
            return $this->render("GoogleApiBundle:Batch:failed.html.twig");
        }
    }
}