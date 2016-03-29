<?php
// AppBundle/Security/User/UserCreator.php
namespace AppBundle\Security\User;

use AppBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use LightSaml\Model\Protocol\Response;
use LightSaml\SpBundle\Security\User\UserCreatorInterface;
use LightSaml\SpBundle\Security\User\UsernameMapperInterface;
use Symfony\Component\Security\Core\User\UserInterface;


class UserCreator implements UserCreatorInterface
{
    /** @var ObjectManager */
    private $objectManager;

    /** @var UsernameMapperInterface */
    private $usernameMapper;

    /**
     * @param ObjectManager           $objectManager
     * @param UsernameMapperInterface $usernameMapper
     */
    public function __construct($objectManager, $usernameMapper)
    {
        $this->objectManager = $objectManager;
        $this->usernameMapper = $usernameMapper;
    }

    /**
     * @param Response $response
     *
     * @return UserInterface|null
     */
    public function createUser(Response $response)
    {
        $role = "";
        $username= $this->usernameMapper->getUsername($response);
        $email = $response->getAllAssertions()[0]->getAllItems()[1]->getAllAttributes()[1]->getAllAttributeValues()[0];
        $dn = $response->getAllAssertions()[0]->getAllItems()[1]->getAllAttributes()[2]->getAllAttributeValues()[0];
        $displayName = $response->getAllAssertions()[0]->getAllItems()[1]->getAllAttributes()[3]->getAllAttributeValues()[0];
        if (isset($response->getAllAssertions()[0]->getAllItems()[1]->getAllAttributes()[4]))
        {
            $role = isset($response->getAllAssertions()[0]->getAllItems()[1]->getAllAttributes()[4]->getAllAttributeValues()[0]);
        }
        if ($role == "GRP-Aramiam-SUPER_ADMIN")
        {
            $role = ['ROLE_SUPER_ADMIN'];
        }elseif ($role == "GRP-Aramiam-ADMIN")
        {
            $role = ['ROLE_ADMIN'];
        }else
        {
            $role = ['ROLE_USER'];
        }

        $user = new User();
        $user
            ->setUsername($username)
            ->setRoles($role)
            ->setEmail($email)
            ->setDn($dn)
            ->setDisplayName($displayName)
        ;

        $this->objectManager->persist($user);
        $this->objectManager->flush();

        return $user;
    }
}