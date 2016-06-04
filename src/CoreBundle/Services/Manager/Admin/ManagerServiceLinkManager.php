<?php
namespace CoreBundle\Services\Manager\Admin;

use AppBundle\Services\Manager\AbstractManager;

/**
 * Class ManagerServiceLinkManager
 * @package CoreBundle\Services\Manager\Admin
 */
class ManagerServiceLinkManager extends AbstractManager
{
    /**
     * @param $userId
     * @return mixed
     */
    public function getlist($userId)
    {
        $sql = "SELECT a.id, b.id, b.service_name, b.parent_service FROM aramiam.core_admin_services_managers a LEFT JOIN core_admin_services b ON a.service_id = b.id WHERE a.user_id = ".$userId." ORDER BY b.service_name";

        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * @param $userId
     * @return int
     */
    public function isManager($userId)
    {
        $lookUser = $this->getRepository()->findBy(array('userId' => $userId));
        if ($lookUser == null) {
            return 0;
        } else {
            return 1;
        }
    }
}