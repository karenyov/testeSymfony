<?php

namespace App\Core\Controller;

use App\Core\Service\MatrizService;
use App\Core\Request\Matriz\MatrizCreateRequest;
use App\Core\Request\Matriz\MatrizUpdateRequest;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/matriz', name: 'matriz_')]
class MatrizController extends AbstractController
{
    public function __construct(
        private readonly MatrizService  $matrizService
    ) {
    }

    #[Route('/', name: 'app_matriz', methods: ['get'])]
    public function index(): JsonResponse
    {
        return new JsonResponse($this->matrizService->findBy(), JsonResponse::HTTP_OK);
    }

    #[Route(name: 'app_matriz_create', methods: ['post'])]
    public function create(MatrizCreateRequest $request): JsonResponse
    {
        return new JsonResponse($this->matrizService->create($request), JsonResponse::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'app_matriz_delete', methods: ['delete'])]
    public function delete(string $id): JsonResponse
    {
        return new JsonResponse($this->matrizService->remove($id), JsonResponse::HTTP_OK);
    }

    #[Route('/{id}', name: 'app_matriz_update', methods: ['put'])]
    public function update(MatrizUpdateRequest $request): JsonResponse
    {
        return new JsonResponse($this->matrizService->update($request), JsonResponse::HTTP_OK);
    }
}
