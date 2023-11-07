<?php

namespace App\Core\DataFixtures;

use App\Core\Entity\Empresa;
use App\Core\Entity\Matriz;
use App\Core\DataFixtures\AppFixtures;

use Doctrine\Persistence\ObjectManager;

class EmpresaMatrizFixtures extends AppFixtures
{
    public function load(ObjectManager $manager): void
    {
        $matrizes = [
            [
                "nome" => "Hospital das Clínicas"
            ],
            [
                "nome" => "Hospital de Santo André"
            ],
            [
                "nome" => "Instituto de Assistência Médica ao Servidor Público Estadual(IAMSPE)"
            ]
        ];

        $matrizesSave = [];
        foreach ($matrizes as $matriz) {
            $data = new Matriz();
            $data->setNome($matriz["nome"]);
            $manager->persist($data);

            $matrizesSave[] = $data;
        }

        $empresas = [
            [
                "nome" => "IAMSPE - MATERIAIS",
                "apelido" => "Materiais",
                "matriz" => $matrizesSave[2]
            ],
            [
                "nome" => "IAMSPE - SERVIÇOS/OUTROS",
                "apelido" => "Medicamentos",
                "matriz" => $matrizesSave[2]
            ],
            [
                "nome" => "IAMSPE - MATERIAIS",
                "apelido" => "Serviço/Outros",
                "matriz" => $matrizesSave[2]
            ]
        ];

        foreach ($empresas as $empresa) {
            $data = new Empresa();
            $data->setNome($empresa["nome"]);
            $data->setApelido($empresa["apelido"]);
            $data->setMatriz($empresa["matriz"]);
            $manager->persist($data);
        }
        $manager->flush();
    }
}
