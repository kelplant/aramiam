<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Routing\Annotation\Route;


class MigrationCheck extends Controller
{
    /**
     * @Route("/admin/mig/check/active_directory", name="mig_check_actve_directory")
     */
    public function migcheckADAction()
    {
        $listToCheck = $this->get('ad.active_directory_user_link_manager')->getRepository()->findAll();
        foreach ($listToCheck as $item) {
            $getLdap = $this->get('ad.active_directory_api_user_service')->findUser($this->getParameter('active_directory'), $item->getIdentifiant());
            if ($getLdap['count'] = 1 && isset($getLdap[0]) && strlen($item->getId()) <= 10) {
                $item->setCn($getLdap[0]["distinguishedname"][0]);
                $item->setDn(str_replace('CN='.$getLdap[0]["cn"][0].',', '', $getLdap[0]["distinguishedname"][0]));
                $item->setId($this->get('ad.active_directory_api_user_service')->toReadableGuid($getLdap[0]["objectsid"][0]));
                $this->get('ad.active_directory_user_link_manager')->save($item);
                $utilisateur = $this->get('core.utilisateur_manager')->load($item->getUser());
                $utilisateur->setIsCreateInWindows($this->get('ad.active_directory_api_user_service')->toReadableGuid($getLdap[0]["objectsid"][0]));
                $this->get('core.utilisateur_manager')->save($utilisateur);
            }
            else {
                if (strlen($item->getId()) <= 10) {
                    $this->get('ad.active_directory_user_link_manager')->remove($item->getId());
                    $utilisateur = $this->get('core.utilisateur_manager')->load($item->getUser());
                    $utilisateur->setIsCreateInWindows(0);
                    $this->get('core.utilisateur_manager')->save($utilisateur);
                }
            }
        }
        $listOfAnos = $this->get('core.utilisateur_manager')->getRepository()->findBy(array('isArchived' => 0, 'isCreateInWindows' => 0));
        foreach ($listOfAnos as $ano) {
            echo  $ano->getViewName();
            echo '<br>';
        }

        return $this->render('@App/Batch/succes.html.twig');
    }

    /**
     * @Route("/admin/mig/check/salesforce", name="mig_check_salesforce")
     */
    public function migcheckSalesforceAction()
    {
        $listToCheck = $this->get('salesforce.user_link_manager')->getRepository()->findBy(array('isActive' => null));
        foreach ($listToCheck as $item) {
            $getSalesforce = json_decode($this->get('salesforce.salesforce_api_user_service')->getAllInfosForAccountByProfilId($item->getId(), $this->getParameter('salesforce')));
            if ($getSalesforce != null) {
                $item->setSalesforceProfil($getSalesforce->ProfileId);
                $item->setIsActive($getSalesforce->IsActive);
                $this->get('salesforce.user_link_manager')->save($item);
            }
            else {
                echo $item->getUser();
                echo '<br>';
            }
        }

        return $this->render('@App/Batch/succes.html.twig');
    }

    /**
     * @Route("/admin/mig/check/odigo", name="mig_check_odigo")
     */
    public function migcheckOdigoAction()
    {
        $userInfos = $this->get('core.utilisateur_manager')->getRepository()->findBy(array('isArchived' => 0));
        foreach ($userInfos as $item) {
            if ($item->getIsCreateInOdigo() != 0 && $item->getIsCreateInOdigo() != null) {
                $odigoLinkInfos = $this->get('odigo.prosodie_odigo_manager')->load($item->getIsCreateInOdigo());
                $getOdigo = $this->get('odigo.service.client')->find($this->getParameter('odigo'), 1, $odigoLinkInfos->getOdigoExtension());
                $show = $item->getViewName();
                if (isset($getOdigo->return->listUsers)) {
                    $ddiNumber = $getOdigo->return->listUsers->directAccessCode;
                    if($ddiNumber != $odigoLinkInfos->getOdigoPhoneNumber()) {
                        echo $show.' - '.$ddiNumber.' = '.$odigoLinkInfos->getOdigoPhoneNumber().' - Wrong Number<br>';
                    } else
                    {
                        //echo $userInfos->getViewName().' - '.$ddiNumber.' = '.$item->getOdigoPhoneNumber().' - Good Number<br>';
                    }
                } else
                {
                    echo $show.' - Missing<br>';
                }
            }
        }
        echo '<br><br>separator<br><br>';

        $userInfos = $this->get('core.utilisateur_manager')->getRepository()->findBy(array('isArchived' => 1));
        foreach ($userInfos as $item) {
            if ($item->getIsCreateInOdigo() != 0 && $item->getIsCreateInOdigo() != null) {
                $odigoLinkInfos = $this->get('odigo.prosodie_odigo_manager')->load($item->getIsCreateInOdigo());
                $getOdigo = $this->get('odigo.service.client')->find($this->getParameter('odigo'), 1, $odigoLinkInfos->getOdigoExtension());
                $show = $item->getViewName();
                if (isset($getOdigo->return->listUsers)) {
                        try {
                            $this->get('odigo.service.client')->delete($this->getParameter('odigo'), $odigoLinkInfos->getOdigoExtension());
                            echo $show.' - Is Exist But Shoudnt - DELETED <br>';
                        } catch (\Exception $e) {
                            echo $show.' - Is Exist But Shoudnt - CANT DELETE <br>';
                        }
                }
            }
        }
        return $this->render('@App/Batch/succes.html.twig');
    }
}