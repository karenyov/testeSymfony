<?php

namespace App\Supply\Controller;

use App\Supply\Request\Pedido\PedidoCreateRequest;
use App\Supply\Request\Pedido\PedidoUpdateRequest;
use App\Supply\Service\PedidoService;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/pedido', name: "supply/pedido_")]
class PedidoController extends AbstractController
{
    public function __construct(
        private readonly PedidoService  $pedidoService
    ) {
    }

    #[Route('/', name: 'supply_pedido', methods: ['get'])]
    public function index(): JsonResponse
    {
        return new JsonResponse($this->pedidoService->findBy(), JsonResponse::HTTP_OK);
    }

    #[Route(name: 'supply_pedido_create', methods: ['post'])]
    public function create(PedidoCreateRequest $request): JsonResponse
    {
        return new JsonResponse($this->pedidoService->create($request), JsonResponse::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'supply_pedido_show', methods: ['get'])]
    public function show(string $id): JsonResponse
    {
        return new JsonResponse($this->pedidoService->findById($id), JsonResponse::HTTP_OK);
    }

    #[Route('/{id}', name: 'supply_pedido_delete', methods: ['delete'])]
    public function delete(string $id): JsonResponse
    {
        return new JsonResponse($this->pedidoService->remove($id), JsonResponse::HTTP_OK);
    }

    #[Route('/{id}', name: 'supply_pedido_update', methods: ['put'])]
    public function update(PedidoUpdateRequest $request): JsonResponse
    {
        return new JsonResponse($this->pedidoService->update($request), JsonResponse::HTTP_OK);
    }
}
