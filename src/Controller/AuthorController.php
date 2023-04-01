<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
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
 * @Route(path="/api/author", name="author.")
 */
class AuthorController extends AbstractController
{
    private $entityManager;
    private $serializer;
    private $repository;

    public function __construct(EntityManagerInterface $entityManager, SerializerInterface $serializer, AuthorRepository $authorRepository)
    {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
        $this->repository = $authorRepository;
    }

    /**
     * @Rest\Get(path="/", name="all")
     * @Rest\View(statusCode=Response::HTTP_OK)
     * @return Author[]
     */
    public function all(): array
    {
        return $this->repository->findAll();
    }

    /**
     * @Rest\Get(path="/{id}/", name="find", requirements={"id"="\d+"})
     * @Rest\View(statusCode=Response::HTTP_OK)
     * @param Author $author
     * @return Author
     */
    public function find(Author $author): Author
    {
        return $author;
    }

    /**
     * @param Author $author
     * @param Request $request
     * @param ConstraintViolationList $violations
     * @return Author
     * @Rest\Post(path="/", name="store")
     * @Rest\View(statusCode=Response::HTTP_OK)
     * @ParamConverter(name="author", converter="fos_rest.request_body")
     */
    public function store(Author $author, Request $request, ConstraintViolationList $violations): Author
    {
        doValidations($violations);
        // $author = $this->serializer->deserialize($request->getContent(), Author::class, 'json'); === @ParamConverter
        $this->entityManager->persist($author);
        $this->entityManager->flush();

        return $author;
    }

    /**
     * @param Request $request
     * @param Author $author
     * @return Author
     * @Rest\Put(path="/{id}/", name="udpate")
     * @Rest\View(statusCode=Response::HTTP_OK)
     */
    public function udpate(Request $request, Author $author): Author
    {
        $form = $this->createForm(AuthorType::class, $author);
        $form->submit(jsonDecode($request->getContent()));

        $this->entityManager->persist($author);
        $this->entityManager->flush();

        return $author;
    }

    /**
     * @param Author $author
     * @return Author
     * @Rest\Delete(path="/{id}/", name="remove")
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     */
    public function remove(Author $author): Author
    {
        $this->entityManager->remove($author);
        $this->entityManager->flush();

        return $author;
    }
}
