<?php

namespace App\Core\DataFixtures;

use App\Core\Entity\Grupo;
use App\Core\Entity\Funcionalidade;
use App\Core\DataFixtures\AppFixtures;

use Doctrine\Persistence\ObjectManager;

class GrupoFuncionalidadeFixtures extends AppFixtures
{
    public function load(ObjectManager $manager): void
    {
        $funcionalidades = [
            [
                "nome" => "Gerenciar Usuários"
            ],
            [
                "nome" => "Gerenciar Grupos"
            ]
        ];

        $funcionalidadesSave = [];
        foreach ($funcionalidades as $funcionalidade) {
            $data = new Funcionalidade();
            $data->setNome($funcionalidade["nome"]);
            $manager->persist($data);

            $funcionalidadesSave[] = $data;
        }

        $grupos = [
            [
                "nome" => "Master",
                "funcionalidades" => [$funcionalidadesSave[0]]
            ],
            [
                "nome" => "Administração",
                "funcionalidades" => [$funcionalidadesSave[0]]
            ]
        ];

        foreach ($grupos as $grupo) {
            $data = new Grupo();
            $data->setNome($grupo["nome"]);

            foreach ($grupo["funcionalidades"] as $f) {
                $data->addFuncionalidade($f);
            }

            $manager->persist($data);
        }
        $manager->flush();
    }
}
