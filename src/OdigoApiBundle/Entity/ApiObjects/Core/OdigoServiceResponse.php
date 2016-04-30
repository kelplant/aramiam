<?php
namespace OdigoApiBundle\Entity\ApiObjects\Core;

/**
 * Class OdigoServiceResponse
 * @package OdigoApiBundle\Entity\ApiObjects\Core
 */
class OdigoServiceResponse
{
    /**
     * The active
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var int
     */
    public $return;

    /**
     * @return int
     */
    public function getReturn()
    {
        return $this->return;
    }

    /**
     * @param int $return
     * @return OdigoServiceResponse
     */
    public function setReturn($return)
    {
        $this->return = $return;
        return $this;
    }
}