<?php
namespace SalesforceApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class SalesforceController
 * @package SalesforceApiBundle\Controller
 */
class SalesforceController extends Controller
{
    /**
     * @Route(path="/salesforce/aouth",name="salesforce_aouth")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function aouthAction()
    {
        return $this->render('@Core/Default/salesforceindex.html.twig');
    }
}