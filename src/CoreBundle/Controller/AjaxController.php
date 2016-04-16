<?php
namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Exception;

/**
 * Class AjaxController
 * @package CoreBundle\Controller
 */
class AjaxController extends Controller
{
    /**
     * @param $service
     * @param $fonction
     * @Route(path="/ajax/check/odigo/isabletouse/{service}/{fonction}",name="ajax_able_use_odigo")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function isAbleToUseOdigo($service, $fonction)
    {
        if ($this->get('core.service_manager')->load($service)->getNameInOdigo() == "" || $this->get('core.fonction_manager')->load($fonction)->getNameInOdigo() == "") {
            return new JsonResponse(0);
        } else {
            return new JsonResponse(1);
        }
    }

    /**
     * @param $email
     * @Route(path="/ajax/check/google/isexist/{email}",name="ajax_exist_in_google")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function isExistGmailAccount($email)
    {
        try {
            return new JsonResponse($this->get('core.google_api_service')->getInfosFromEmail($this->get('core.google_api_service')->innitApi(), $email));
        } catch (Exception $e) {
            return new JsonResponse('nouser');
        }
    }

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