<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Exception;

/**
 * Class AjaxController
 * @package AppBundle\Controller
 */
class AjaxController extends Controller
{
    /**
     * @Route(path="/ajax/get/credentials",name="ajax_get_credentials")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getCredentialsForSecurity()
    {
        $user = $this->get('fos_user.user_manager')->findUserByUsername($this->get('security.token_storage')->getToken()->getUser()->getUsername());
        return new JsonResponse(array('user' => $user->getUsername(), 'password' => $user->getPassword()));
    }
}