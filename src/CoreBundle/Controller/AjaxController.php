<?php
/**
 * Created by PhpStorm.
 * User: Xavier
 * Date: 02/04/2016
 * Time: 05:57
 */

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AjaxController extends Controller
{
    /**
     * @param $itemEdit
     * @Route(
     *     path="/ajax/candidat/get/{itemEdit}",
     *     name="ajax_get_candidat")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getCandidatInfosIndex($itemEdit)
    {
        $item = $this->get('core.candidat_manager')->getRepository()->findOneById($itemEdit);
        $itemArray = [];
        $itemArray['id'] = $item->getId();
        $itemArray['name'] = $item->getName();
        $itemArray['surname'] = $item->getSurname();
        $itemArray['civilite'] = $item->getCivilite();
        $itemArray['startDate'] = $item->getStartDate()->format('d-m-Y');
        $itemArray['agence'] = $item->getAgence();
        $itemArray['service'] = $item->getService();
        $itemArray['fonction'] = $item->getFonction();
        $itemArray['statusPoste'] = $item->getStatusPoste();
        $itemArray['predecesseur'] = $item->getPredecesseur();
        $itemArray['responsable'] = $item->getResponsable();
        $itemArray['matriculeRH'] = $item->getMatriculeRH();
        $itemArray['commentaire'] = $item->getCommentaire();
        $itemArray['isArchived'] = $item->getIsArchived();

        return new JsonResponse($itemArray);
    }

    /**
     * @param $itemEdit
     * @Route(
     *     path="/ajax/agence/get/{itemEdit}",
     *     name="ajax_get_agence")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getAgenceInfosIndex($itemEdit)
    {
        $item = $this->get('core.agence_manager')->getRepository()->findOneById($itemEdit);
        $itemArray = [];
        $itemArray['id'] = $item->getId();
        $itemArray['name'] = $item->getName();
        $itemArray['nameInCompany'] = $item->getNameInCompany();
        $itemArray['nameInOdigo'] = $item->getNameInOdigo();
        $itemArray['nameInSalesforce'] = $item->getNameInSalesforce();
        $itemArray['nameInZendesk'] = $item->getNameInZendesk();

        return new JsonResponse($itemArray);
    }

    /**
     * @param $itemEdit
     * @Route(
     *     path="/ajax/fonction/get/{itemEdit}",
     *     name="ajax_get_fonction")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getFonctionInfosIndex($itemEdit)
    {
        $item = $this->get('core.fonction_manager')->getRepository()->findOneById($itemEdit);

        $itemArray = [];
        $itemArray['id'] = $item->getId();
        $itemArray['name'] = $item->getName();
        $itemArray['shortName'] = $item->getShortName();
        $itemArray['nameInCompany'] = $item->getNameInCompany();
        $itemArray['nameInOdigo'] = $item->getNameInOdigo();
        $itemArray['nameInSalesforce'] = $item->getNameInSalesforce();
        $itemArray['nameInZendesk'] = $item->getNameInZendesk();

        return new JsonResponse($itemArray);
    }

    /**
     * @param $itemEdit
     * @Route(
     *     path="/ajax/service/get/{itemEdit}",
     *     name="ajax_get_service")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getServiceInfosIndex($itemEdit)
    {
        $item = $this->get('core.service_manager')->getRepository()->findOneById($itemEdit);
        $itemArray = [];
        $itemArray['id'] = $item->getId();
        $itemArray['name'] = $item->getName();
        $itemArray['shortName'] = $item->getShortName();
        $itemArray['nameInCompany'] = $item->getNameInCompany();
        $itemArray['nameInOdigo'] = $item->getNameInOdigo();
        $itemArray['nameInSalesforce'] = $item->getNameInSalesforce();
        $itemArray['nameInZendesk'] = $item->getNameInZendesk();

        return new JsonResponse($itemArray);
    }
}