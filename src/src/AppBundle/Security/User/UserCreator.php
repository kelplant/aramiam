<?php
namespace AppBundle\Security\User;

use AppBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use GoogleApiBundle\Entity\GooglePhotoUser;
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

    protected $superAdminGroup;

    protected $adminGroup;

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
            $googlePhotoUser = new GooglePhotoUser();
            $googlePhotoUser->setMimeType('image/jpeg');
            $googlePhotoUser->setPhotoData('_9j_4AAQSkZJRgABAQAAAQABAAD_2wCEAAUDBA8ODRAQDw0PDQ0NDw8QEA0QEA0PEBEQEBIQEA8VDw4ODRAPDxAPEA0QEBUQEBISFRMVEBAYGBYSGBMSFxIBBQUFCAcIDgkJDxUVEhUXGhsdFRcXFhcXHhoVFRYeFRoVFRkVFxUaFh4TFRIVFRUSFRUWFRUVFRUVHxUZFRUYFf_AABEIAGAAYAMBIgACEQEDEQH_xAAdAAACAgMBAQEAAAAAAAAAAAAABwQGAwUIAgEJ_8QAQhAAAgECAwQHBAcFBwUAAAAAAQIRAAMEEiEFMUFRBgcTImFx8DJCgZEIFCNSYnKhorHB0eEzU4OSo8PxFSQlQ2P_xAAaAQACAwEBAAAAAAAAAAAAAAADBAACBQYB_8QALREAAgECBAQEBgMAAAAAAAAAAQIAAxEEITFRE0FxkRJhwdEFFCKhsfBC4fH_2gAMAwEAAhEDEQA_AGXRRRSsNK11mbXu4fCtds5c6PbnMuYZWYKZAIMd4aggjfSC6QbYfEXmuvbRGcDN2YYAkCJhmYyQADqN0xM1duuq8MxK4m-ktku4R3uqNQSrpbJyNaMQSuZQcu4yAuUJ46-I4_D0KOgyg2MyevWtfPXrWvLmNRu9a14GI51eVvMjpNebVuB8T-pmvjXxXlsRUklp6H9Ob2D3TdsCZsMxAHjbaGNsjfAGU66SZDt6D9K7eNtl0DKVMOjA90-DRlYEagg7t4B0rmoMG0I36fPfyqzdW21vq-LtsfYdhbcSQIfuhokA5C06g6Zo31RkBlladHUUev5UUCEhRRRUknNXWQ6_XMRlAUdoVgCBKwrfEsCSeZJq79TvVGMVZ7fENct2rg-ytoQGYffJYMAp90Ad7fMRNJxuzTiNpvZOna426hj7pvPmI8QgJ867AwdoKiqoCqqgKo3AAQABwAgaVTFVigCrrG8DhlqEs2gikbqCwsHLicUCd09gR8hZH6EVpcV9HkmcuPA5ThifmRiB86fVFJDFVBzmgcFRP8fzOd3-j3fG7GWW87VxP9x6lbI-j2xYG_jAF4pZt94-Vy4YX422p_UVb5urvPPkKI5fcxFdcXVNbt4VHwdqDhgxuoJa5dQwS5Yyzvbyk5fuloGgFI1L0qecaEf0ruY-vXr-XKHWB0fS1tY2kAFu7dslVG4dsUDAchmZoHAEDlTOErlvpaJY_DBfrXpaP8-O_wBTRQaKLEoUUVG2ofs2ncAJ_KCC37M1V28IJl6a-Jgu5iSwn2W31MT_AN3w_wDsDr_rTXQ-K21c0FqznAibjsEWfwiJbzAjlPFPdItlRt7Dns0trcdXAQQv2asBEQCSLaEnxp_bLw9tiDczZeOXeY4EyIHMjXdBGhpLEnilCMrj1mxglFEOCL2b0_znKwNt4ob8Kh8roH763GxMdcuSXtC0BoBnDknj7IgADzPy1qGyeg-JG0hdfHg4BXLNaLXmZ1zEgBOxXLKlVKlmywxDtoKYH1ZEJFssySYLTmjxJkmN07zvOppbhMuZa_b2jYrq-QQjqCPUyDtnFXEXMlvtRrK5gh4QQWBBG-Rv3RxrSHbmKO7CoPzXVP7qtLWg3dYlVbQlYLAHfE6TrpO7kdxX_WR0GxN3GB8Hj_q-FJXMha_3QEtqQE7IknMj3C2clzciEyy04bNmGt29pOOqZFCegPuJYMHtu6DF6xlU--jZwD-JIDR4iY_clOtXD_8Am8MfvfU3B_LeYHX_AA_lXRm0cNaWTazRHvcD-Eli0Hk248YgBN9YWCL7XwEItw5WlW9khWMZtD3Qz74-dGw5NJzc3yP4i-LUVqYAFrkfc25nz3lzoqPs6Mughc75R-HO2WPCIgcqkVoI3iUHeYtVPA5XY27Qr4yzodQdD68a-0VaUlP6c2yv_T8RxwuLXDu27uOwtgnmYVB5uabGAOhHI1R9oYUPbuW2si5mbPbYsAEbuGSDrIa2CCAd5GkmbdsXFhwrDc6zH8DyKmQfhWS9xZSNL9p0NMhruCDexPW372mzFYTc76iRpJI5d3SfOf8Ams1QruChi6HK8zO8HQLqN-5eB3_rUwgko3RMTry9eXwr3Ua1htQ5OZtCNIA0I0kZtQxEEn4VIqCQzDjT3fPT165UvMZYb69iL_C3hbGGsnlcu3bjXSOErNrx0q97YxAUEncgLHyH9AaqSElQptZHLK9y5mWGhi4EDvTmMajQSJIioAzGy_t5GZFXxMRv2kizbCgAblED4bq90UVsAWnNE3NzCiiipPIVk2PiOzcqfZc5kPAOfaU8sx7y8yWHKcYrY9Huj31xntBwmVJY7yCT3JWQe8QeWgMa0KtS4i2GvKM4WvwnudDrN6CGHgZ4kfqNRxqHiNnLv-1JHAXbo-U3AKw4qzdwrlXUunzcDmP7xeTDvcCGMmp-ExKuuZWDDmP48j4GsvyOs3uV1OW8jYXCA6kXAebXG1-CuV-EDyqYihRvMb5JJ8d5Jr5ibyqCzMFUbyTA-ZrX2RcxLBLasqn3iIYjmAfZH4m15AyCJ5CTlc6TVbcxWdsg1AIL_CCq_HRmHAQPeqPWw6S7CGDNq211WNxSVJIUswI7SATLQWUzv7wnU1rzWnRpcNc9ZhYqvxXy0GkKKKKNFYCqPt7p8oJXDqt0gkG609mCNDlAhrhBEGCq8mNT-sra5tWcinK98lZ4qgE3GHkIUEaguDwpMX72py91THdGgkaT8RGnhREW-sqzSy7X6R3Ln9pfc_gU5F8stvLI_PPnvq8_RZ6Y28LiOxeFt43uB9BF627C3mPK5nZZPvZOZpN1iVj7IE6sQSYAUwWJ0O4ncNTIotoOfoftXZqXVyuJ5EaEeR4VQdt9CihLiY4uhKNA-_lIJgc5FVHqR67bTWDZx14JesKMt9__AHJMCd_2okAj3x3t-eMv0nNpXV7G2L4W3cVi-GUkEwdGcj2kOq5SQJGgaCQnjaaeAuwzE3PgNKricSuHRrA31BOguch_Q3lo2N0KNwhjmjeHclzr9wMTE8xA8TV-2TsxLKwgjmTvPmfQpTfRguubF77cuqOoXDmSEEEyCfZFwmAF0lG0k1F69uuZLFs4fB3A2JfMty6pnsApKMJ1HbSpAHu-1xTNMHSQIHAzMr8cWpQxT4dmuFOxHK-h69NovvpX9MUxOIOGSGt4S3dVm0IN94DDduthAsj3iw4Cl3snbzW_7O9ct_hklf8AI2a3-zVYdyTBG8g5s28SCZEbzu1Pz1rNTsxY1Ni9YBGmIUZP75AdBze3J001ZCfyga1f7F4MoZSGVgGDDUEESCDxB3zXN1t4j7syRwMaj9QKa3VJtjMrWSdFHaWvykxcX_Dcg-AcAaLQnTmJdWn_2Q==');
        }

        return $this->setUser($username, $role, $email, $dn, $displayName, $googlePhotoUser);
    }

    /**
     * @param mixed $superAdminGroup
     * @return UserCreator
     */
    public function setSuperAdminGroup($superAdminGroup)
    {
        $this->superAdminGroup = $superAdminGroup;
        return $this;
    }

    /**
     * @param mixed $adminGroup
     * @return UserCreator
     */
    public function setAdminGroup($adminGroup)
    {
        $this->adminGroup = $adminGroup;
        return $this;
    }
}
