<?php
namespace CoreBundle\Controller\Applications\Salesforce;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


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