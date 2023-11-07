<?php

namespace App\Core\Controller;

use App\Core\Service\EmpresaService;
use App\Core\Request\Empresa\EmpresaCreateRequest;
use App\Core\Request\Empresa\EmpresaUpdateRequest;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/empresa', name: 'empresa_')]
class EmpresaController extends AbstractController
{
    public function __construct(
        private readonly EmpresaService  $empresaService
    ) {
    }

    #[Route('/', name: 'app_empresa', methods: ['get'])]
    public function index(): JsonResponse
    {
        return new JsonResponse($this->empresaService->findBy(), JsonResponse::HTTP_OK);
    }

    #[Route(name: 'app_empresa_create', methods: ['post'])]
    public function create(EmpresaCreateRequest $request): JsonResponse
    {
        return new JsonResponse($this->empresaService->create($request), JsonResponse::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'app_empresa_update', methods: ['put'])]
    public function update(EmpresaUpdateRequest $request): JsonResponse
    {
        return new JsonResponse($this->empresaService->update($request), JsonResponse::HTTP_OK);
    }
}
