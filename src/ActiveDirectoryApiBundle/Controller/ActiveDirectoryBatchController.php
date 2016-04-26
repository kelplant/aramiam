<?php
namespace ActiveDirectoryApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use GuzzleHttp;

/**
 * Class ActiveDirectoryBatchController
 * @package ActiveDirectoryApiBundle\Controller
 */
class ActiveDirectoryBatchController extends Controller
{
    private function transcodeSid($hashAndCryptedSid)
    {
        $sidinhex = str_split(bin2hex($hashAndCryptedSid), 2);
        $sid = 'S-'.hexdec($sidinhex[0])."-".hexdec($sidinhex[6].$sidinhex[5].$sidinhex[4].$sidinhex[3].$sidinhex[2].$sidinhex[1]);
        $subauths = hexdec($sidinhex[7]);
        for ($i = 0; $i < $subauths; $i++) {
            $start = 8 + (4 * $i);
            $sid = $sid."-".hexdec($sidinhex[$start + 3].$sidinhex[$start + 2].$sidinhex[$start + 1].$sidinhex[$start]);
        }
        return $sid;
    }

    /**
     * @Route(path="/batch/active_directory/groupe/reload/{login}/{password}",name="batch_active_directory_profile")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function reloadActiveDirectoryGroupeTable($login, $password)
    {
        if ($this->get('app.security.acces_service')->validateUser($login, $password) === true)
        {
            $this->get('ad.active_directory_group_manager')->truncateTable();
            $response = $this->get('ad.active_directory_api_service')->executeQueryWithFilter($this->getParameter('active_directory'), '(objectCategory=group)', array("objectSid", "dn", "name"));
            foreach ((array)$response as $record) {
                if (!is_null($record['dn'])) {
                    $explodeSid = explode('-', $this->transcodeSid($record['objectsid'][0]));
                    $this->get('ad.active_directory_group_manager')->add(array('id' => $explodeSid[7], 'name' => $record['name'][0], 'dn' => $record['dn']));
                }
            }
            return $this->render("ActiveDirectoryApiBundle:Batch:succes.html.twig");
        } else {
            return $this->render("ActiveDirectoryApiBundle:Batch:failed.html.twig");
        }
    }
}