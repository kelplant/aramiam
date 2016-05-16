<?php
namespace AppBundle\Security\User;

use AppBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use GoogleApiBundle\Services\GoogleApiService;
use GoogleApiBundle\Services\GoogleUserApiService;
use LightSaml\Model\Protocol\Response;
use LightSaml\SpBundle\Security\User\UserCreatorInterface;
use LightSaml\SpBundle\Security\User\UsernameMapperInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserCreator extends Controller implements UserCreatorInterface
{
    /** @var ObjectManager */
    private $objectManager;

    /** @var UsernameMapperInterface */
    private $usernameMapper;

    /** @var GoogleUserApiService */
    private $googleUserApiService;

    /**
     * @param ObjectManager           $objectManager
     * @param UsernameMapperInterface $usernameMapper
     * @param GoogleUserApiService    $googleUserApiService
     */
    public function __construct($objectManager, $usernameMapper, $googleUserApiService)
    {
        $this->objectManager = $objectManager;
        $this->usernameMapper = $usernameMapper;
        $this->googleUserApiService = $googleUserApiService;
    }

    /**
     * @param $username
     * @param $role
     * @param $email
     * @param $dn
     * @param $displayName
     * @param $googlePhotoUser
     * @return User
     */
    private function setUser($username, $role, $email, $dn, $displayName, $googlePhotoUser)
    {
        $user = new User();
        $user
            ->setUsername($username)
            ->setRoles($role)
            ->setEmail($email)
            ->setDn($dn)
            ->setDisplayName($displayName);
        if ($googlePhotoUser != null) {
            $user
                ->setPhoto($googlePhotoUser->getPhotoData())
                ->setPhotoMineType($googlePhotoUser->getMimeType());
        }
        $this->objectManager->persist($user);
        $this->objectManager->flush();

        return $user;
    }

    /**
     * @param $role
     * @return array
     */
    private function defineRole($role)
    {
        if ($role == "GRP-Aramiam-SUPER_ADMIN") {
            $role = ['ROLE_SUPER_ADMIN'];
        } elseif ($role == "GRP-Aramiam-ADMIN") {
            $role = ['ROLE_ADMIN'];
        } else {
            $role = ['ROLE_USER'];
        }
        return $role;
    }

    /**
     * @param Response $response
     *
     * @return UserInterface|null
     */
    public function createUser(Response $response)
    {
        $role = "";
        $username = $this->usernameMapper->getUsername($response);
        $email = $response->getAllAssertions()[0]->getAllItems()[1]->getAllAttributes()[1]->getAllAttributeValues()[0];
        $dn = $response->getAllAssertions()[0]->getAllItems()[1]->getAllAttributes()[2]->getAllAttributeValues()[0];
        $displayName = $response->getAllAssertions()[0]->getAllItems()[1]->getAllAttributes()[3]->getAllAttributeValues()[0];
        if (isset($response->getAllAssertions()[0]->getAllItems()[1]->getAllAttributes()[4])) {
            $role = $response->getAllAssertions()[0]->getAllItems()[1]->getAllAttributes()[4]->getAllAttributeValues()[0];
        }
        $role = $this->defineRole($role);
        try {
            $googlePhotoUser = $this->googleUserApiService->getPhotoOfUser($this->getParameter('google_api'), $email);
        } catch (\Exception $e) {
            $googlePhotoUser = null;
        }
        $user = $this->setUser($username, $role, $email, $dn, $displayName, $googlePhotoUser);

        return $user;
    }
}