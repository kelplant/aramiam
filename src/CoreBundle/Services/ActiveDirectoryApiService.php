<?php
namespace CoreBundle\Services;


class ActiveDirectoryApiService
{
    private function connectAD($connectionADparams)
    {
        $ds = ldap_connect($connectionADparams['ldaphost']);
        ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_bind($ds, $connectionADparams['ldapUsername'], $connectionADparams['ldapPassword']) or die("\r\nCould not connect to LDAP server\r\n");

        return $ds;
    }

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