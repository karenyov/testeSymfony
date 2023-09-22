<?php

namespace App\Supply\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/', name: 'supply_home')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'supply_home', methods: ['get'])]
    public function index(): JsonResponse
    {

        $data = [];

        return $this->json($data);
    }
}
