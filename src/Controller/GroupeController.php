<?php

namespace App\Controller;

use App\Controller\Traits\Validations;
use App\Entity\Groupe;
use App\Form\GroupeType;
use App\Repository\GroupeRepository;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\ConstraintViolationList;


/**
 * @Route(path="/api/groupe", name="groupe.")
 */
class GroupeController extends AbstractController
{
    use Validations;

    private $entityManager;
    private $serializer;
    private $repository;

    public function __construct(EntityManagerInterface $entityManager, SerializerInterface $serializer, GroupeRepository $groupeRepository)
    {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
        $this->repository = $groupeRepository;
    }

    /**
     * @Rest\Get(path="/", name="all")
     * @Rest\View(statusCode=Response::HTTP_OK)
     * @return Groupe[]
     */
    public function all(): array
    {
        return $this->repository->findAll();
    }

    /**
     * @Rest\Get(path="/{id}/", name="find", requirements={"id"="\d+"})
     * @Rest\View(statusCode=Response::HTTP_OK)
     */
    public function find(Groupe $groupe): Groupe
    {
        return $groupe;
    }

    /**
     * @Rest\Post(path="/", name="store")
     * @Rest\View(statusCode=Response::HTTP_OK)
     * @ParamConverter(name="groupe", converter="fos_rest.request_body")
     */
    public function store(Groupe $groupe, Request $request, ConstraintViolationList $violations): Groupe
    {
        $this->validate($violations);

        $this->entityManager->persist($groupe);
        $this->entityManager->flush();

        return $groupe;
    }

    /**
     * @Rest\Put(path="/{id}/", name="udpate")
     * @Rest\View(statusCode=Response::HTTP_OK)
     */
    public function udpate(Request $request, Groupe $groupe): Groupe
    {
        $form = $this->createForm(GroupeType::class, $groupe);
        $form->submit(jsonDecode($request->getContent()));

        $this->entityManager->persist($groupe);
        $this->entityManager->flush();

        return $groupe;
    }

    /**
     * @Rest\Delete(path="/{id}/", name="remove")
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     */
    public function remove(Groupe $groupe): Groupe
    {
        $this->entityManager->remove($groupe);
        $this->entityManager->flush();

        return $groupe;
    }
}
