<?php

namespace App\Core\Controller;

use App\Core\Service\UsuarioService;
use App\Core\Request\Usuario\UsuarioCreateRequest;
use App\Core\Request\Usuario\UsuarioUpdateRequest;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/usuario', name: 'usuario_')]
class UsuarioController extends AbstractController
{
    public function __construct(
        private readonly UsuarioService  $usuarioService
    ) {
    }

    #[Route('/', name: 'app_usuario', methods: ['get'])]
    public function index(): JsonResponse
    {
        return new JsonResponse($this->usuarioService->findBy(), JsonResponse::HTTP_OK);
    }

    #[Route(name: 'app_usuario_create', methods: ['post'])]
    public function create(UsuarioCreateRequest $request): JsonResponse
    {
        return new JsonResponse($this->usuarioService->create($request), JsonResponse::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'app_usuario_update', methods: ['put'])]
    public function update(UsuarioUpdateRequest $request): JsonResponse
    {
        return new JsonResponse($this->usuarioService->update($request), JsonResponse::HTTP_OK);
    }

    #[Route('/{id}', name: 'app_usuario_show', methods: ['get'])]
    public function show(string $id): JsonResponse
    {
        return new JsonResponse($this->usuarioService->findById($id), JsonResponse::HTTP_OK);
    }
}
