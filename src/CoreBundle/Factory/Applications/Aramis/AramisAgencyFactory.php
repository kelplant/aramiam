<?php
namespace CoreBundle\Factory\Applications\Aramis;

use CoreBundle\Factory\AbstractFactory;
use CoreBundle\Entity\Applications\Aramis\AramisAgency;
use Doctrine\Common\Util\Inflector;

class AramisAgencyFactory extends AbstractFactory
{


    /**
     * @param $aramisAgency
     * @return AramisAgency
     */
    public function createFromEntity($aramisAgency)
    {
        $addAgency = new AramisAgency();
        foreach ($aramisAgency as  $key => $value)
        {
            if (!in_array("set" . Inflector::camelize($key), array ("opening_text1", "opening_hours1", "opening_text2", "opening_hours2", "setlinks", "setschedules", "setpurchaseCalendar", "setsaleCalendar", "setpurchaseSaleCalendar", "setsalespersons", "setappointementRadius"))) {
                if ($value != "") {
                    $addAgency->{"set" . Inflector::camelize($key)}($value);
                }
            }
        }
        return $addAgency;
    }
}