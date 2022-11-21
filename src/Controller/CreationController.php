<?php

namespace App\Controller;

use App\Entity\Creation;
use App\Entity\User;
use App\Repository\CreationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class CreationController
 * @package App\Controller
 * @Route("/creations")
 */
class CreationController
{
    /**
     * @Route(name="api_creations_collection_get", methods={"GET"})
     * @param CreationRepository $creationRepository
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function collection(CreationRepository $creationRepository, SerializerInterface $serializer): JsonResponse
    {
        return new JsonResponse(
            $serializer->serialize($creationRepository->findAll(), "json", ["groups" => "get"]),
            JsonResponse::HTTP_OK,
            [],
            true
        );
        
    }

    /**
     * @Route("/{id}", name="api_creations_item_get", methods={"GET"})
     * @param Creation $creation
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function item(Creation $creation, SerializerInterface $serializer): JsonResponse
    {
        return new JsonResponse(
            $serializer->serialize($creation, "json", ["groups" => "get"]),
            JsonResponse::HTTP_OK,
            [],
            true
        );
    }

    /**
     * @Route(name="api_creations_collection_creation", methods={"POST"})
     * @param Creation $creation
     * @param EntityManagerInterface $entityManager
     * @param SerializerInterface $serializer
     * @param UrlGeneratorInterface $urlGenerator
     * @param ValidatorInterface $validator
     * @return JsonResponse
     */
    public function creation(
        Creation $creation,
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer,
        UrlGeneratorInterface $urlGenerator,
        ValidatorInterface $validator
    ): JsonResponse {

        $errors = $validator->validate($creation);

        if ($errors->count() > 0) {
            return new JsonResponse($serializer->serialize($errors, 'json'), JsonResponse::HTTP_BAD_REQUEST, [], true);
        }

        $entityManager->persist($creation);
        $entityManager->flush();

        return new JsonResponse(
            $serializer->serialize($creation, "json", ["groups" => "get"]),
            JsonResponse::HTTP_CREATED,
            ["Location" => $urlGenerator->generate("api_creations_item_get", ["id" => $creation->getId()])],
            true
        );
    }

    /**
     * @Route("/{id}", name="api_creations_item_put", methods={"PUT"})
     * @param Creation $creation
     * @param EntityManagerInterface $entityManager
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     * @return JsonResponse
     */
    public function put(
        Creation $creation,
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer,
        ValidatorInterface $validator
    ): JsonResponse {
        $errors = $validator->validate($creation);

        if ($errors->count() > 0) {
            return new JsonResponse($serializer->serialize($errors, 'json'), JsonResponse::HTTP_BAD_REQUEST, [], true);
        }

        $entityManager->flush();

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }

    /**
     * @Route("/{id}", name="api_creations_item_delete", methods={"DELETE"})
     * @param Creation $creation
     * @param EntityManagerInterface $entityManager
     * @return JsonResponse
     */
    public function delete(
        Creation $creation,
        EntityManagerInterface $entityManager
    ): JsonResponse {
        $entityManager->remove($creation);
        $entityManager->flush();

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
