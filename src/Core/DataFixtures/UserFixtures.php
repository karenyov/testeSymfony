<?php

namespace App\Core\DataFixtures;

use App\Core\Entity\Usuario;
use App\Core\Entity\Grupo;
use App\Core\DataFixtures\AppFixtures;

use Doctrine\Persistence\ObjectManager;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends AppFixtures
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $grupoRepository = $manager->getRepository(Grupo::class);

        $usuario = new Usuario();
        $usuario->setNome("Sistema");
        $usuario->setEmail("sistema@email.com");
        $plaintextPassword = "brasil";
        $hashedPassword = $this->passwordHasher->hashPassword(
            $usuario,
            $plaintextPassword
        );
        $usuario->setPassword($hashedPassword);

        $grupo = $grupoRepository->findOneBy(["nome" => "Master"]);
        $usuario->setGrupo($grupo);

        $manager->persist($usuario);

        $manager->flush();
    }
}
