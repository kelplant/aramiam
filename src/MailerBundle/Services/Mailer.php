<?php
namespace MailerBundle\Services;

use CoreBundle\Services\Manager\Admin\UtilisateurManager;
use OdigoApiBundle\Services\Manager\ProsodieOdigoManager;
use Symfony\Component\Templating\EngineInterface;
use Swift_Mailer;
use Swift_Message;

class Mailer
{
    protected $from;

    protected $name;

    protected $mailer;

    protected $templating;

    protected $utilisateurManager;

    protected $odigoManager;

    /**
     * Mailer constructor.
     * @param Swift_Mailer $mailer
     * @param EngineInterface $templating
     * @param UtilisateurManager $utilisateurManager
     * @param ProsodieOdigoManager $odigoManager
     */
    public function __construct($mailer, $templating, $utilisateurManager, $odigoManager)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->from = "xavier.arroues@aramisauto.com";
        $this->name = "[Aramiam] Identifiants";
        $this->utilisateurManager = $utilisateurManager;
        $this->odigoManager = $odigoManager;
    }

    /**
     * @param $to
     * @param $subject
     * @param $body
     */
    private function sendMessage($to, $subject, $body)
    {
        $mail = Swift_Message::newInstance();
        $mail
            ->setFrom($this->from)
            ->setTo($to)
            ->setSubject($subject)
            ->setBody($body)
            ->setContentType('text/html');
        $this->mailer->send($mail);
        die();
    }

    /**
     * @param $numUser
     */
    public function sendInfosMessage($numUser)
    {
        $userInfos = $this->utilisateurManager->createArray($numUser);
        $subject = 'Identidiants pour '.$userInfos['viewName'];
        $to = 'kelplant@gmail.com';
        $body = $this->templating->render('MailerBundle:Mails:nouvelArrivantMail.html.twig', array(
            'userInfos' => $userInfos,
            'odigoUserInfos' => $this->odigoManager->createArrayByUser($numUser),
            ));
        $this->sendMessage($to, $subject, $body);
    }
}