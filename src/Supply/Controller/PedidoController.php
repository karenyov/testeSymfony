<?php

namespace App\Supply\Controller;

use App\Supply\Entity\Pedido;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/pedido', name: 'supply_home')]
class PedidoController extends AbstractController
{
    #[Route('/', name: 'supply_pedido', methods: ['get'])]
    public function index(EntityManagerInterface $entityManager): JsonResponse
    {

        $pedidoRepository = $entityManager->getRepository(Pedido::class);
        $pedidos = $pedidoRepository->findAll();

        $data = [];
        foreach ($pedidos as $pedido) {
            $data[] = [
                'id' => $pedido->getId(),
                'num_pedido' => $pedido->numPedido(),
                'ano_pedido' => $pedido->getAnoPedido(),
                'empresa' => $pedido->getEmpresa()->getNome()
            ];
        }

        return new JsonResponse([
            'data' => $data
        ]);
    }
}
