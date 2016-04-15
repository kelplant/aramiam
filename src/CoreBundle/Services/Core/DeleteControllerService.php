<?php
namespace CoreBundle\Services\Core;

/**
 * Class DeleteControllerService
 * @package CoreBundle\Services\Core
 */
class DeleteControllerService extends AbstractControllerService
{
    protected $remove;

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function generateDeleteAction()
    {
        $this->message = $this->generateMessage($this->remove);
        $this->insert = $this->remove;

        return $this->get('core.index.controller_service')->getFullList($this->isArchived);
    }

    /**
     * @param $remove
     * @return $this
     */
    public function setRemove($remove)
    {
        $this->remove = $remove;
        return $this;
    }
}