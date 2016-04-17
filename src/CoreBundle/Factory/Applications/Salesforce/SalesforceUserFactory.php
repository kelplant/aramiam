<?php
namespace CoreBundle\Factory\Applications\Salesforce;

use CoreBundle\Factory\AbstractFactory;
use CoreBundle\Entity\Applications\Salesforce\SalesforceUser;

class SalesforceUserFactory extends AbstractFactory
{
    /**
     * @param $salesforceUser
     * @return SalesforceUser
     */
    public function createFromEntity($salesforceUser)
    {
        $salesforceUser = new SalesforceUser(
            $salesforceUser['Username'],
            $salesforceUser['LastName'],
            $salesforceUser['FirstName'],
            $salesforceUser['Email'],
            $salesforceUser['TimeZoneSidKey'],
            $salesforceUser['Alias'],
            $salesforceUser['CommunityNickname'],
            $salesforceUser['IsActive'],
            $salesforceUser['LocaleSidKey'],
            $salesforceUser['EmailEncodingKey'],
            $salesforceUser['ProfileId'],
            $salesforceUser['LanguageLocaleKey'],
            $salesforceUser['UserPermissionsMobileUser'],
            $salesforceUser['UserPreferencesDisableAutoSubForFeeds']
        );

        return $salesforceUser;
    }
}