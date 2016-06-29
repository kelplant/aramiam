<?php
namespace ActiveDirectoryApiBundle\Services;

use ActiveDirectoryApiBundle\Services\Manager\ActiveDirectoryGroupManager;
use ActiveDirectoryApiBundle\Services\Manager\ActiveDirectoryGroupMatchFonctionManager;
use ActiveDirectoryApiBundle\Services\Manager\ActiveDirectoryGroupMatchServiceManager;
use ActiveDirectoryApiBundle\Services\Manager\ActiveDirectoryOrganisationUnitManager;
use ActiveDirectoryApiBundle\Services\Manager\ActiveDirectoryUserLinkManager;
use CoreBundle\Services\Manager\Admin\ServiceManager;
use CoreBundle\Services\Manager\Admin\UtilisateurManager;

/**
 * Class AbstractActiveDirectoryApiService
 * @package ActiveDirectoryApiBundle\Services
 */
class AbstractActiveDirectoryApiService
{
    /**
     * @var ServiceManager
     */
    protected $serviceManager;

    /**
     * @var UtilisateurManager
     */
    protected $utilisateurManager;

    /**
     * @var ActiveDirectoryGroupManager
     */
    protected $activeDirectoryGroupManager;

    /**
     * @var ActiveDirectoryGroupMatchFonctionManager
     */
    protected $activeDirectoryGroupMatchFonctionManager;

    /**
     * @var ActiveDirectoryGroupMatchServiceManager
     */
    protected $activeDirectoryGroupMatchServiceManager;

    /**
     * @var ActiveDirectoryOrganisationUnitManager
     */
    protected $activeDirectoryOrganisationUnitManager;

    /**
     * @var ActiveDirectoryUserLinkManager;
     */
    protected $activeDirectoryUserLinkManager;

    /**
     * ActiveDirectoryApiService constructor.
     * @param ServiceManager $serviceManager
     * @param UtilisateurManager $utilisateurManager
     * @param ActiveDirectoryGroupManager $activeDirectoryGroupManager
     * @param ActiveDirectoryGroupMatchFonctionManager $activeDirectoryGroupMatchFonctionManager
     * @param ActiveDirectoryGroupMatchServiceManager $activeDirectoryGroupMatchServiceManager
     * @param ActiveDirectoryOrganisationUnitManager $activeDirectoryOrganisationUnitManager
     * @param ActiveDirectoryUserLinkManager $activeDirectoryUserLinkManager
     */
    public function __construct(ServiceManager $serviceManager, UtilisateurManager $utilisateurManager, ActiveDirectoryGroupManager $activeDirectoryGroupManager, ActiveDirectoryGroupMatchFonctionManager $activeDirectoryGroupMatchFonctionManager, ActiveDirectoryGroupMatchServiceManager $activeDirectoryGroupMatchServiceManager, ActiveDirectoryOrganisationUnitManager $activeDirectoryOrganisationUnitManager, ActiveDirectoryUserLinkManager$activeDirectoryUserLinkManager)
    {
        $this->serviceManager                           = $serviceManager;
        $this->utilisateurManager                       = $utilisateurManager;
        $this->activeDirectoryGroupManager              = $activeDirectoryGroupManager;
        $this->activeDirectoryGroupMatchFonctionManager = $activeDirectoryGroupMatchFonctionManager;
        $this->activeDirectoryGroupMatchServiceManager  = $activeDirectoryGroupMatchServiceManager;
        $this->activeDirectoryOrganisationUnitManager   = $activeDirectoryOrganisationUnitManager;
        $this->activeDirectoryUserLinkManager           = $activeDirectoryUserLinkManager;
    }

    /**
     * @param $connectionADparams
     * @return resource
     */
    public function connectAD($connectionADparams)
    {
        try {
            $ds = ldap_connect($connectionADparams['ldaphost']);
            ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_bind($ds, $connectionADparams['ldapUsername'], $connectionADparams['ldapPassword']);
            return $ds;
        } catch (\Exception $e) {
            $this->utilisateurManager->appendSessionMessaging(array('errorCode' => error_log($e->getMessage()), 'message' => $e->getMessage()));
        }
    }

    /**
     * @param $newPassword
     * @return string
     */
    public function pwd_encryption($newPassword)
    {
        $newPassword = "\"".$newPassword."\"";
        $newPassw = "";
        for ($i = 0; $i < strlen($newPassword); $i++) {
            $newPassw .= "{$newPassword{$i}}\000";
        }
        return $newPassw;
    }

    /**
     * @param $guidFromAd
     * @return string
     */
    public function toReadableGuid($guidFromAd)
    {
        $hex = unpack("H*hex", $guidFromAd)["hex"];
        return substr($hex, -26, 2).substr($hex, -28, 2).substr($hex, -30, 2).substr($hex, -32, 2)."-".substr($hex, -22, 2).substr($hex, -24, 2)."-".substr($hex, -18, 2).substr($hex, -20, 2)."-".substr($hex, -16, 4)."-".substr($hex, -12, 12);
    }
}