<?php

namespace App\Core\Service;

use App\Core\Entity\Empresa;
use App\Core\Service\BaseService;
use App\Core\Repository\EmpresaRepository;
use App\Core\Repository\MatrizRepository;
use App\Core\Request\Empresa\EmpresaCreateRequest;
use App\Core\Request\Empresa\EmpresaUpdateRequest;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EmpresaService extends BaseService
{
    public function __construct(
        private readonly EmpresaRepository $empresaRepository,
        private readonly MatrizRepository $matrizRepository
    ) {
    }

    public function findBy(): array
    {
        $empresas = $this->empresaRepository->findAll();

        $data = [];
        foreach ($empresas as $empresa) {
            $data[] = [
                'id' => $empresa->getId(),
                'nome' => $empresa->getNome(),
                'apelido' => $empresa->getApelido(),
                'matriz' => $empresa->getMatriz()->getNome()
            ];
        }
        return $this->setData($data)
            ->response();
    }

    public function create(EmpresaCreateRequest $empresaRequest): array
    {
        $empresa = new Empresa();
        $empresa->setNome($empresaRequest->getNome());
        $empresa->setApelido($empresaRequest->getApelido());

        $matrizId = $empresaRequest->getMatrizId();
        if ($matrizId !== null) {
            $matriz = $this->matrizRepository->find($matrizId);
            if (!$matriz) {
                throw new NotFoundHttpException('Matriz não encontrada.');
            }
        }
        $empresa->setMatriz($matriz);
        $this->empresaRepository->save($empresa);

        $data = [
            'empresa' => [
                'id' => $empresa->getId(),
                'nome' => $empresa->getNome(),
                'apelido' => $empresa->getApelido(),
                'matriz' => $empresa->getMatriz()->getNome()
            ]
        ];
        return $this->setData($data)
            ->setMessage('Empresa criada com sucesso')
            ->response();
    }

    public function update(EmpresaUpdateRequest $empresaRequest): array
    {
        if ($empresaRequest->getId() !== null) {
            $empresa = $this->empresaRepository->find($empresaRequest->getId());
            if (!$empresa) {
                throw new NotFoundHttpException('Empresa não encontrada.');
            }
        }
        $empresa->setNome($empresaRequest->getNome());
        $empresa->setApelido($empresaRequest->getApelido());

        $matrizId = $empresaRequest->getMatrizId();
        if ($matrizId !== null) {
            $matriz = $this->matrizRepository->find($matrizId);
            if (!$matriz) {
                throw new NotFoundHttpException('Matriz não encontrada.');
            }
        }
        $empresa->setMatriz($matriz);

        $this->empresaRepository->update($empresa);

        $data = [
            'id' => $empresa->getId(),
            'nome' => $empresa->getNome(),
            'apelido' => $empresa->getApelido(),
            'matriz' => $empresa->getMatriz()->getNome()
        ];

        return $this->setData($data)
            ->setMessage('Empresa atualizada com sucesso.')
            ->response();
    }
}
