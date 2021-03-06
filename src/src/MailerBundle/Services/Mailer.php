<?php
namespace MailerBundle\Services;

use ActiveDirectoryApiBundle\Services\Manager\ActiveDirectoryUserLinkManager;
use AramisApiBundle\Entity\AramisRobusto;
use AramisApiBundle\Services\Manager\AramisRobustoManager;
use CoreBundle\Services\Manager\Admin\UtilisateurManager;
use OdigoApiBundle\Services\Manager\ProsodieOdigoManager;
use Symfony\Component\HttpFoundation\Request;
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
     * @var ActiveDirectoryUserLinkManager
     */
    protected $activeDirectoryUserLinkManager;

    /** @var  AramisRobustoManager */
    protected $aramisRobustoManager;

    /**
     * Mailer constructor.
     * @param Swift_Mailer $mailer
     * @param EngineInterface $templating
     * @param UtilisateurManager $utilisateurManager
     * @param ProsodieOdigoManager $odigoManager
     * @param ActiveDirectoryUserLinkManager $activeDirectoryUserLinkManager
     * @param AramisRobustoManager $aramisRobustoManager
     */
    public function __construct(Swift_Mailer $mailer, EngineInterface $templating, UtilisateurManager $utilisateurManager, ProsodieOdigoManager $odigoManager, ActiveDirectoryUserLinkManager $activeDirectoryUserLinkManager, AramisRobustoManager $aramisRobustoManager)
    {
        $this->mailer                         = $mailer;
        $this->templating                     = $templating;
        $this->name                           = "[Aramiam] Identifiants";
        $this->utilisateurManager             = $utilisateurManager;
        $this->odigoManager                   = $odigoManager;
        $this->activeDirectoryUserLinkManager = $activeDirectoryUserLinkManager;
        $this->aramisRobustoManager           = $aramisRobustoManager;
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
        } elseif ($to == '2') {
            $responsableInfos = $this->utilisateurManager->createArray($userInfos['responsable']);
            $to = array($userInfos['email'],$responsableInfos['email']);
        }

        $subject = '[AramIAM] - Identidiants pour '.$userInfos['viewName'];
        $body    = $this->templating->render('MailerBundle:Mails:nouvelArrivantMail.html.twig', array(
            'userInfos'            => $userInfos,
            'odigoUserInfos'       => $this->odigoManager->createArrayByUser($numUser),
            'activeDirectoryInfos' => $this->activeDirectoryUserLinkManager->createArray($numUser),
            'robustoInfos'         => $this->aramisRobustoManager->createArray($numUser),
            ));

        return $this->sendMessage($to, $subject, $body);
    }

    /**
     * @param $request
     * @param $to
     * @return int
     */
    public function sendRecruteurMessage($request, $to, $from)
    {
        $this->from = $from;

        if ($request['matriculeRH'] == '') {
            $subject = '[AramIAM] - Candidat Tranformé : ALERTE MATRICULE RH ABSENT - '.$request['surname'].' '.$request['name'];
        } else {
            $subject = '[AramIAM] - Candidat Tranformé : '.$request['surname'].' '.$request['name'];
        }
        $body    = $this->templating->render('MailerBundle:Mails:RecruteurAlertOnCandidatTransform.html.twig', array(
            'templateInfos'      => $request,
        ));

        return $this->sendMessage($to, $subject, $body);
    }


    /**
     * @param string $from
     * @return Mailer
     */
    public function setFrom($from)
    {
        $this->from = $from;
        return $this;
    }
}