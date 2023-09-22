<?php

namespace App\Core\Controller;

use App\Core\Entity\Empresa;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/empresa', name: 'app_')]
class EmpresaController extends AbstractController
{
    #[Route('/', name: 'app_empresa', methods: ['get'])]
    public function index(EntityManagerInterface $entityManager): JsonResponse
    {
        $empresaRepository = $entityManager->getRepository(Empresa::class);
        $empresas = $empresaRepository->findAll();

        $data = [];
        foreach ($empresas as $empresa) {
            $data[] = [
                'id' => $empresa->getId(),
                'nome' => $empresa->getNome(),
                'apelido' => $empresa->getApelido(),
                'matriz' => $empresa->getMatriz()->getNome()
            ];
        }

        return new JsonResponse([
            'data' => $data
        ]);
    }
}
