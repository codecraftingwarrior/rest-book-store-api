<?php

namespace App\Controller;

use App\Entity\TypeDocument;
use App\Form\TypeDocumentType;
use App\Repository\TypeDocumentRepository;
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
 * @Route(path="/api/type-document", name="type_document.")
 */
class TypeDocumentController extends AbstractController
{
    private $entityManager;
    private $serializer;
    private $repository;

    public function __construct(EntityManagerInterface $entityManager, SerializerInterface $serializer, TypeDocumentRepository $typeDocumentRepository)
    {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
        $this->repository = $typeDocumentRepository;
    }

    /**
     * @Rest\Get(path="/", name="all")
     * @Rest\View(statusCode=Response::HTTP_OK)
     * @return TypeDocument[]
     */
    public function all(): array
    {
        return $this->repository->findAll();
    }

    /**
     * @Rest\Get(path="/{id}/", name="find", requirements={"id"="\d+"})
     * @Rest\View(statusCode=Response::HTTP_OK)
     */
    public function find(TypeDocument $typeDocument): TypeDocument
    {
        return $typeDocument;
    }

    /**
     * @Rest\Post(path="/", name="store")
     * @Rest\View(statusCode=Response::HTTP_OK)
     * @ParamConverter(name="typeDocument", converter="fos_rest.request_body")
     */
    public function store(TypeDocument $typeDocument, Request $request, ConstraintViolationList $violations): TypeDocument
    {
        doValidations($violations);

        $this->entityManager->persist($typeDocument);
        $this->entityManager->flush();

        return $typeDocument;
    }

    /**
     * @Rest\Put(path="/{id}/", name="udpate")
     * @Rest\View(statusCode=Response::HTTP_OK)
     */
    public function udpate(Request $request, TypeDocument $typeDocument): TypeDocument
    {
        $form = $this->createForm(TypeDocumentType::class, $typeDocument);
        $form->submit(jsonDecode($request->getContent()));

        $this->entityManager->persist($typeDocument);
        $this->entityManager->flush();

        return $typeDocument;
    }

    /**
     * @Rest\Delete(path="/{id}/", name="remove")
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     */
    public function remove(TypeDocument $typeDocument): TypeDocument
    {
        $this->entityManager->remove($typeDocument);
        $this->entityManager->flush();

        return $typeDocument;
    }
}
