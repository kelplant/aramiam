<?php
namespace MailerBundle\Services;

use CoreBundle\Services\Manager\Admin\UtilisateurManager;
use OdigoApiBundle\Services\Manager\ProsodieOdigoManager;
use Symfony\Component\Templating\EngineInterface;
use Swift_Mailer;
use Swift_Message;

class Mailer
{
    /**
     * @var string
     */
    protected $from;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var Swift_Mailer
     */
    protected $mailer;

    /**
     * @var EngineInterface
     */
    protected $templating;

    /**
     * @var UtilisateurManager
     */
    protected $utilisateurManager;

    /**
     * @var ProsodieOdigoManager
     */
    protected $odigoManager;

    /**
     * Mailer constructor.
     * @param Swift_Mailer $mailer
     * @param EngineInterface $templating
     * @param UtilisateurManager $utilisateurManager
     * @param ProsodieOdigoManager $odigoManager
     */
    public function __construct(Swift_Mailer $mailer, EngineInterface $templating, UtilisateurManager $utilisateurManager, ProsodieOdigoManager $odigoManager)
    {
        $this->mailer             = $mailer;
        $this->templating         = $templating;
        $this->from               = "xavier.arroues@aramisauto.com";
        $this->name               = "[Aramiam] Identifiants";
        $this->utilisateurManager = $utilisateurManager;
        $this->odigoManager       = $odigoManager;
    }

    /**
     * @param $to
     * @param $subject
     * @param $body
     * @return int
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
        return $this->mailer->send($mail);
    }

    /**
     * @param $numUser
     * @param $to
     * @return int
     */
    public function sendInfosMessage($numUser, $to)
    {
        $userInfos = $this->utilisateurManager->createArray($numUser);
        if ($to == '1') {
            $to = $userInfos['email'];
        } else {
            $to = '';
        }
        $subject = 'Identidiants pour '.$userInfos['viewName'];
        $body = $this->templating->render('MailerBundle:Mails:nouvelArrivantMail.html.twig', array(
            'userInfos' => $userInfos,
            'odigoUserInfos' => $this->odigoManager->createArrayByUser($numUser),
            ));
        return $this->sendMessage($to, $subject, $body);
    }
}