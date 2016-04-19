<?php
namespace CoreBundle\Factory\Applications\Aramis;

use CoreBundle\Factory\AbstractFactory;
use CoreBundle\Entity\Applications\Aramis\AramisAgency;
use CoreBundle\Services\Manager\Applications\Aramis\AramisAgencyManager;
use Doctrine\Common\Util\Inflector;

class AramisAgencyFactory extends AbstractFactory
{
    protected $aramisAgencyManager;

    /**
     * AramisAgencyFactory constructor.
     * @param AramisAgencyManager $aramisAgencyManager
     */
    public function __construct(AramisAgencyManager $aramisAgencyManager)
    {
        $this->aramisAgencyManager = $aramisAgencyManager;
    }

    /**
     * @param $aramisAgency
     * @return AramisAgency
     */
    public function createFromEntity($aramisAgency)
    {
        $addAgency = new AramisAgency();
        foreach ($aramisAgency as  $key => $value)
        {
            if (!in_array("set" . Inflector::camelize($key), array ("setlinks", "setschedules", "setpurchaseCalendar", "setsaleCalendar", "setpurchaseSaleCalendar", "setsalespersons", "setappointementRadius"))) {
                if ($value != "") {
                    $addAgency->{"set" . Inflector::camelize($key)}($value);
                }
            }
        }
        $id = $addAgency->getId();
        if ($id != "" && $id != "00") {
            try {
                $this->aramisAgencyManager->save($addAgency);
                return array ('id' => $id, 'status' => "OK");
            } catch (\Exception $e) {
                return array ('id' => $id, 'status' => $e->getMessage());
            }
        } else {
            return array ('id' => 'noId', 'status' => "KO");
        }
    }
}