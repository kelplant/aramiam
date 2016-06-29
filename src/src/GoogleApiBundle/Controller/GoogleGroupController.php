<?php
namespace GoogleApiBundle\Controller;

use CoreBundle\Services\Core\AbstractControllerService;
use GoogleApiBundle\Entity\GoogleGroup;
use GoogleApiBundle\Form\GoogleGroupType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class GoogleGroupController
 * @package GoogleApiBundle\Controller
 */
class GoogleGroupController extends AbstractControllerService
{
    /**
     *
     */
    private function initData($service)
    {
        $this->selfInit('GoogleGroup', 'google', GoogleGroup::class, GoogleGroupType::class, array());
        $this->get('core.'.$service.'.controller_service')->setEntity('GoogleGroup');
        $this->get('core.'.$service.'.controller_service')->setNewEntity(GoogleGroup::class);
        $this->get('core.'.$service.'.controller_service')->setFormType(GoogleGroupType::class);
        $this->get('core.'.$service.'.controller_service')->setAlertText('ce groupe Gmail');
        $this->get('core.'.$service.'.controller_service')->setIsArchived(NULL);
        $this->get('core.'.$service.'.controller_service')->setCreateFormArguments(array());
        $this->get('core.'.$service.'.controller_service')->setServicePrefix('google');
    }

    /**
     * @param $request
     */
    private function ifGoogleGroupeMatchFonctionAndServiceAdd($request)
    {
        if (isset($request->request->get('match')['count'])) {
            $this->get('google.google_group_match_fonction_and_service_manager')->purge($request->request->get('google_group')['id']);
            for ($i = 1; $i <= $request->request->get('match')['count']; $i++) {
                $this->get('google.google_group_match_fonction_and_service_manager')->add(array('gmailGroupId' => $request->request->get('google_group')['id'], 'fonctionId' => $request->request->get('match')['fonction'.$i], 'serviceId' => $request->request->get('match')['service'.$i]));
            }
        }
    }

    /**
     * @Route(path="/app/google/groupe_liste", name="google_groupe_liste")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $this->initData('index');
        return $this->get('core.index.controller_service')->generateIndexAction(NULL);
    }

    /**
     * @param Request $request
     * @Route(path="/app/google/groupe/edit", name="form_exec_edit_google_groupe")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function form_exec_editAction(Request $request)
    {
        $this->initData('index');
        $this->formAdd = $this->generateForm();
        $this->formEdit = $this->generateForm();
        $this->formEdit->handleRequest($request);
        if ($this->formEdit->isSubmitted() && $this->formEdit->isValid()) {
            if ($request->request->get('formAction') == 'edit') {
                $this->ifGoogleGroupeMatchFonctionAndServiceAdd($request);
            }
        }
        return $this->get('core.index.controller_service')->getFullList(null, $this->formAdd, $this->formEdit);
    }
}