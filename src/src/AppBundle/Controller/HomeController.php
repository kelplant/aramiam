<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class HomeController
 * @package AppBundle\Controller
 */
class HomeController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function homeAction()
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {

            if ($this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')) {
                return $this->redirect($this->generateUrl('admin_main_dashboard'));
            }
            if ($this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
                return $this->redirect($this->generateUrl('user_launcher'));
            }
        }
        return $this->render('@App/Default/noaccess.view.html.twig');
    }
}