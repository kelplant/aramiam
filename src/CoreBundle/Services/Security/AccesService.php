<?php
namespace CoreBundle\Services\Security;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class SecurityAccesService
 * @package CoreBundle\Services
 */
class AccesService extends Controller
{
    /**
     * @param $login
     * @param $password
     * @return bool
     */
    public function validateUser($login, $password)
    {
        $user = $this->get('fos_user.user_manager')->findUserByUsername($login);
        return ($password == $user->getPassword()) ? true : false;
    }
}