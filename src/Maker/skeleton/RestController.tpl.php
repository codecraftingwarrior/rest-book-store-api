<?= "<?php\n" ?>

namespace App\Controller;

use App\Entity\<?=$entity_class_name?>;
use App\Form\<?=$entity_class_name?>Type;
use App\Repository\<?=$repository_class_name?>;
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
 * @Route(path="/api/<?=$route?>", name="<?=$entity_twig_var_singular?>.")
 */
class <?=$entity_class_name?>Controller extends AbstractController
{
    private $entityManager;
    private $serializer;
    private $repository;

    public function __construct(EntityManagerInterface $entityManager, SerializerInterface $serializer, <?=$repository_class_name?> $<?=lcfirst($repository_class_name)?>)
    {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
        $this->repository = $<?=lcfirst($repository_class_name)?>;
    }

    /**
     * @Rest\Get(path="/", name="all")
     * @Rest\View(statusCode=Response::HTTP_OK)
     * @return <?=$entity_class_name?>[]
     */
    public function all(): array
    {
        return $this->repository->findAll();
    }

    /**
     * @Rest\Get(path="/{id}/", name="find", requirements={"id"="\d+"})
     * @Rest\View(statusCode=Response::HTTP_OK)
     */
    public function find(<?=$entity_class_name?> $<?=$entity_var_singular?>): <?=$entity_class_name?>
    {
        return $<?=$entity_var_singular?>;
    }

    /**
     * @Rest\Post(path="/", name="store")
     * @Rest\View(statusCode=Response::HTTP_OK)
     * @ParamConverter(name="<?=$entity_var_singular?>", converter="fos_rest.request_body")
     */
    public function store(<?=$entity_class_name?> $<?=$entity_var_singular?>, Request $request, ConstraintViolationList $violations): <?=$entity_class_name?>
    {
        doValidations($violations);

        $this->entityManager->persist($<?=$entity_var_singular?>);
        $this->entityManager->flush();

        return $<?=$entity_var_singular?>;
    }

    /**
     * @Rest\Put(path="/{id}/", name="udpate")
     * @Rest\View(statusCode=Response::HTTP_OK)
     */
    public function udpate(Request $request, <?=$entity_class_name?> $<?=$entity_var_singular?>):  <?=$entity_class_name?>
    {
        $form = $this->createForm(<?=$entity_class_name?>Type::class, $<?=$entity_var_singular?>);
        $form->submit(jsonDecode($request->getContent()));

        $this->entityManager->persist($<?=$entity_var_singular?>);
        $this->entityManager->flush();

        return $<?=$entity_var_singular?>;
    }

    /**
     * @Rest\Delete(path="/{id}/", name="remove")
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     */
    public function remove(<?=$entity_class_name?> $<?=$entity_var_singular?>): <?=$entity_class_name?>
    {
        $this->entityManager->remove($<?=$entity_var_singular?>);
        $this->entityManager->flush();

        return $<?=$entity_var_singular?>;
    }
}
