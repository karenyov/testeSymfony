<?php

namespace App\Supply\Service;

use App\Core\Service\BaseService;
use App\Supply\Request\Pedido\PedidoUpdateRequest;
use App\Supply\Request\Pedido\PedidoCreateRequest;
use App\Supply\Entity\Pedido;
use App\Supply\Repository\PedidoRepository;
use App\Core\Repository\EmpresaRepository;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PedidoService extends BaseService
{
    public function __construct(
        private readonly PedidoRepository $pedidoRepository,
        private readonly EmpresaRepository $empresaRepository
    ) {
    }

    public function create(PedidoCreateRequest $pedidoRequest): array
    {
        $empresaId = $pedidoRequest->getEmpresaId();

        $pedido = new Pedido();
        $pedido->setNumPedido($pedidoRequest->getNumPedido());
        $pedido->setAnoPedido($pedidoRequest->getAnoPedido());

        if ($empresaId !== null) {
            $empresa = $this->empresaRepository->find($empresaId);
            if (!$empresa) {
                throw new NotFoundHttpException('Empresa não encontrada.');
            }
        }
        $pedido->setEmpresa($empresa);
        $this->pedidoRepository->save($pedido);

        $data = [
            'pedido' => [
                'id' => $pedido->getId(),
                'num_pedido' => $pedido->getNumPedido(),
                'ano_pedido' => $pedido->getAnoPedido(),
                'empresa' => $pedido->getEmpresa()->getNome()
            ]
        ];
        return $this->setData($data)
            ->setMessage('Pedido criado com sucesso')
            ->response();
    }

    public function findById(string $id): array
    {
        if ($id !== null) {
            $pedido = $this->pedidoRepository->find($id);
            if (!$pedido) {
                throw new NotFoundHttpException('Pedido não encontrado.');
            }
        }

        $data =  [
            'id' => $pedido->getId(),
            'num_pedido' => $pedido->getNumPedido(),
            'ano_pedido' => $pedido->getAnoPedido(),
            'empresa' => $pedido->getEmpresa()->getNome()
        ];

        return $this->setData($data)
            ->response();
    }

    public function findBy(): array
    {
        $pedidos = $this->pedidoRepository->findAll();

        $data = [];
        foreach ($pedidos as $pedido) {
            $data[] = [
                'id' => $pedido->getId(),
                'num_pedido' => $pedido->getNumPedido(),
                'ano_pedido' => $pedido->getAnoPedido(),
                'empresa' => $pedido->getEmpresa()->getNome()
            ];
        }

        return $this->setData($data)
            ->response();
    }

    public function remove(string $id): array
    {
        $pedido = $this->pedidoRepository->find($id);
        if (!$pedido) {
            throw new NotFoundHttpException('Pedido não encontrado.');
        }

        $pedido = $this->pedidoRepository->remove($pedido);

        return $this->setData([])
            ->setMessage('Pedido removido com sucesso.')
            ->response();
    }

    public function update(PedidoUpdateRequest $pedidoRequest): array
    {
        if ($pedidoRequest->getId() !== null) {
            $pedido = $this->pedidoRepository->find($pedidoRequest->getId());
            if (!$pedido) {
                throw new NotFoundHttpException('Pedido não encontrado.');
            }
        }

        $empresaId = $pedidoRequest->getEmpresaId();
        if ($empresaId !== null) {
            $empresa = $this->empresaRepository->find($empresaId);
            if (!$empresa) {
                throw new NotFoundHttpException('Empresa não encontrada.');
            }
        }
        $pedido->setEmpresa($empresa);
        $pedido->setNumPedido($pedidoRequest->getNumPedido());
        $pedido->setAnoPedido($pedidoRequest->getAnoPedido());

        $this->pedidoRepository->update($pedido);

        $data = [
            'id' => $pedido->getId(),
            'num_pedido' => $pedido->getNumPedido(),
            'ano_pedido' => $pedido->getAnoPedido(),
            'empresa' => $pedido->getEmpresa()->getNome()
        ];

        return $this->setData($data)
            ->setMessage('Pedido atualizado com sucesso.')
            ->response();
    }
}
