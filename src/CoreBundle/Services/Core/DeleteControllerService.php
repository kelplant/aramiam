<?php
namespace CoreBundle\Services\Core;

/**
 * Class DeleteControllerService
 * @package CoreBundle\Services\Core
 */
class DeleteControllerService extends AbstractControllerService
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function generateDeleteAction()
    {
        $this->message = $this->generateMessage($this->remove);
        $this->insert = $this->remove;

        return $this->getFullList($this->isArchived);
    }
}