<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use JMS\Serializer\SerializerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(path="/api/book", name="book.")
 */
class BookController extends AbstractController
{
    private $entityManager;
    private $serializer;
    private $repository;

    public function __construct(EntityManagerInterface $entityManager, SerializerInterface $serializer, BookRepository $bookRepository)
    {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
        $this->repository = $bookRepository;
    }

    /**
     * @Rest\Get(path="/", name="all")
     * @Rest\View(statusCode=Response::HTTP_OK)
     * @IsGranted("ROLE_USER_VIEW")
     * @Rest\QueryParam(
     *     name="pageNumber",
     *     requirements="\d+",
     *     default="1",
     *     nullable=true
     * )
     * @Rest\QueryParam(
     *     name="itemCount",
     *     requirements="\d+",
     *     default="10",
     *     nullable=true
     * )
     */
    public function all($pageNumber, $itemCount, PaginatorInterface $paginator): iterable
    {
        return $paginator
            ->paginate($this->entityManager->createQuery('SELECT b FROM App\Entity\Book b'), $pageNumber, $itemCount)->getItems();
    }

    /**
     * @Rest\Get(path="/{id}/", name="find", requirements={"id"="\d+"})
     * @Rest\View(statusCode=Response::HTTP_OK)
     * @param Book $book
     * @return Book
     */
    public function find(Book $book): Book
    {
        return $book;
    }

    /**
     * @param Request $request
     * @return Book
     * @Rest\Post(path="/", name="store")
     * @Rest\View(statusCode=Response::HTTP_OK)
     */
    public function store(Request $request): Book
    {
        $book = $this->serializer->deserialize($request->getContent(), Book::class, 'json');

        $this->entityManager->persist($book);
        $this->entityManager->flush();

        return $book;
    }

    /**
     * @param Request $request
     * @param Book $book
     * @return Book
     * @Rest\Put(path="/{id}/", name="udpate")
     * @Rest\View(statusCode=Response::HTTP_OK)
     */
    public function udpate(Request $request, Book $book): Book
    {
        $form = $this->createForm(BookType::class, $book);
        $form->submit(jsonDecode($request->getContent()));

        $this->entityManager->persist($book);
        $this->entityManager->flush();

        return $book;
    }

    /**
     * @param Book $book
     * @return Book
     * @Rest\Delete(path="/{id}/", name="remove")
     * @Rest\View(statusCode=Response::HTTP_OK)
     */
    public function remove(Book $book): Book
    {
        $this->entityManager->remove($book);
        $this->entityManager->flush();

        return $book;
    }
}
