<?php
namespace GoogleApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Exception;

/**
 * Class GoogleAjaxController
 * @package GoogleApiBundle\Controller
 */
class GoogleAjaxController extends Controller
{
    /**
     * @param $googleGroupEdit
     * @Route(path="/ajax/google_group/get/{googleGroupEdit}",name="ajax_get_google_group")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function googleGroupGetInfosIndex($googleGroupEdit)
    {
        return new JsonResponse($this->get('google.google_group_manager')->createArray($googleGroupEdit));
    }

    /**
     * @param $gmailGroupId
     * @Route(path="/ajax/get/google/group_fonction_service/{gmailGroupId}",name="ajax_get_google_group_fonction_service")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getGoogleGroupForFonctionAndService($gmailGroupId)
    {
        $groupesIds = $this->get('google.google_group_match_fonction_and_service_manager')->getRepository()->findBy(array('gmailGroupId' =>$gmailGroupId), array());
        $groupes = [];
        foreach ($groupesIds as $groupe)
        {
            $groupes[] = array('gmailGroupId' => $groupe->getGmailGroupId(), 'fonctionId' => $groupe->getFonctionId(), 'serviceId' => $groupe->getServiceId());
        }
        return new JsonResponse($groupes);
    }
}