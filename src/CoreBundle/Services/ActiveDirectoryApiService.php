<?php
namespace CoreBundle\Services;

/**
 * Class ActiveDirectoryApiService
 * @package CoreBundle\Services
 */
class ActiveDirectoryApiService
{
    /**
     * @param $connectionADparams
     * @return resource
     */
    private function connectAD($connectionADparams)
    {
        $ds = ldap_connect($connectionADparams['ldaphost']);
        ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_bind($ds, $connectionADparams['ldapUsername'], $connectionADparams['ldapPassword']);

        return $ds;
    }

    /**
     * @param $connectionADparams
     * @param $userToCreateDn
     * @param $userToCreate
     * @return bool|\Exception|string
     */
    public function createUser($connectionADparams, $userToCreateDn, $userToCreate)
    {
        $ds = $this->connectAD($connectionADparams);

        try {
            $e = ldap_add($ds, $userToCreateDn, $userToCreate);
        } catch (\Exception $e) {
            $e = $e->getMessage();
        }
        ldap_unbind($ds);

        return $e;
    }
}