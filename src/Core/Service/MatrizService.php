<?php

namespace App\Core\Service;

use App\Core\Entity\Matriz;
use App\Core\Service\BaseService;
use App\Core\Repository\MatrizRepository;
use App\Core\Request\Matriz\MatrizCreateRequest;
use App\Core\Request\Matriz\MatrizUpdateRequest;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MatrizService extends BaseService
{
    public function __construct(
        private readonly MatrizRepository $matrizRepository,

    ) {
    }

    public function findBy(): array
    {
        $matrizes = $this->matrizRepository->findAll();

        $data = [];
        foreach ($matrizes as $matriz) {
            $data[] = [
                'id' => $matriz->getId(),
                'nome' => $matriz->getNome(),
            ];
        }
        return $this->setData($data)
            ->response();
    }

    public function create(MatrizCreateRequest $matrizRequest): array
    {
        $matriz = new Matriz();
        $matriz->setNome($matrizRequest->getNome());

        $this->matrizRepository->save($matriz);

        $data = [
            'matriz' => [
                'id' => $matriz->getId(),
                'nome' => $matriz->getNome()
            ]
        ];
        return $this->setData($data)
            ->setMessage('Matriz criada com sucesso')
            ->response();
    }

    public function remove(string $id): array
    {
        $pedido = $this->matrizRepository->find($id);
        if (!$pedido) {
            throw new NotFoundHttpException('Matriz não encontrada.');
        }

        $pedido = $this->matrizRepository->remove($pedido);

        return $this->setData([])
            ->setMessage('Matriz removida com sucesso.')
            ->response();
    }

    public function update(MatrizUpdateRequest $matrizRequest): array
    {
        if ($matrizRequest->getId() !== null) {
            $matriz = $this->matrizRepository->find($matrizRequest->getId());
            if (!$matriz) {
                throw new NotFoundHttpException('Matriz não encontrado.');
            }
        }
        $matriz->setNome($matrizRequest->getNome());

        $this->matrizRepository->update($matriz);

        $data = [
            'id' => $matriz->getId(),
            'nome' => $matriz->getNome()
        ];

        return $this->setData($data)
            ->setMessage('Matriz atualizada com sucesso.')
            ->response();
    }
}
