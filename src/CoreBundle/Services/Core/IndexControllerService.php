<?php
namespace CoreBundle\Services\Core;


class IndexControllerService extends AbstractControllerService
{
    /**
     * @param $isArchived
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function generateIndexAction($isArchived)
    {
        return $this->getFullList($isArchived);
    }
}