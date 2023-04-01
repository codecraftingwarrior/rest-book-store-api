<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\ConstraintViolationList;

class BaseController extends AbstractController
{
    protected $entityManager;

    protected $serializer;

    public function __construct(EntityManagerInterface $entityManager, SerializerInterface $serializer)
    {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
    }

    protected function validate(ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'Impossible de procéder à cette opération.';
            foreach ($violations as $violation) {
                $message .= sprintf("%s: %s ", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new UnprocessableEntityHttpException($message);
        }
    }
}
