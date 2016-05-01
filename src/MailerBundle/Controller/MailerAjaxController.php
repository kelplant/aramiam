<?php
namespace MailerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Exception;

/**
 * Class MailerAjaxController
 * @package MailerBundle\Controller
 */
class MailerAjaxController extends Controller
{
    /**
     * @Route(path="/ajax/send/mail/to_user/{userId}",name="ajax_send_mail_to_user")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function sendMailToUserId($userId)
    {
        return new JsonResponse($this->get('mailer.mailer_service')->sendInfosMessage($userId, '1'));
    }
}