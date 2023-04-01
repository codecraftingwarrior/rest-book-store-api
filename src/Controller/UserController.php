<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route(path="/api/user", name="user.")
 */
class UserController extends AbstractController
{
    private $entityManager;
    private $repository;
    private $encoder;

    public function __construct(EntityManagerInterface $entityManager, UserRepository $repository, UserPasswordEncoderInterface $encoder)
    {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
        $this->encoder = $encoder;
    }

    /**
     * @param Request $request
     * @param User $user
     * @return User
     * @Rest\Post(path="/", name="store")
     * @Rest\View(statusCode=Response::HTTP_OK)
     * @ParamConverter(name="user", converter="fos_rest.request_body")
     */
    public function register(Request $request, User $user): User
    {
        $user->setPassword($this->encoder->encodePassword($user, $user->getPassword()));
        $user->setRoles([
            'ROLE_USER'
        ]);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}
