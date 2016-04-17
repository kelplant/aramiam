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
        $this->initBothForms();

        return $this->get('core.index.controller_service')->getFullList($this->isArchived, $this->formAdd, $this->formEdit);
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