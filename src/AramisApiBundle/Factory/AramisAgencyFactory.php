<?php
namespace AramisApiBundle\Factory;

use CoreBundle\Factory\AbstractFactory;
use AramisApiBundle\Entity\AramisAgency;
use Doctrine\Common\Util\Inflector;

/**
 * Class AramisAgencyFactory
 * @package AramisApiBundle\Factory
 */
class AramisAgencyFactory extends AbstractFactory
{
    /**
     * @param $aramisAgency
     * @return AramisAgency
     */
    public function createFromEntity($aramisAgency)
    {
        $addAgency = new AramisAgency();
        foreach ($aramisAgency as  $key => $value) {
            if (!in_array("set".Inflector::camelize($key), array("setshortUrl", "setdetailPageTitle", "setopeningHours2", "setopeningText2", "setfullUrl", "setopeningText1", "setopeningHours1", "setopening_text1", "setopening_hours1", "setopening_text2", "setopening_hours2", "setlinks", "setschedules", "setpurchaseCalendar", "setsaleCalendar", "setpurchaseSaleCalendar", "setsalespersons", "setappointementRadius"))) {
                if ($value != "") {
                    $addAgency->{"set".Inflector::camelize($key)}($value);
                }
            }
        }
        return $addAgency;
    }
}