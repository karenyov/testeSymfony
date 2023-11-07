<?php

namespace App\Core\Service;

use App\Core\Entity\Usuario;
use App\Core\Service\BaseService;
use App\Core\Repository\UsuarioRepository;
use App\Core\Repository\GrupoRepository;
use App\Core\Request\Usuario\UsuarioCreateRequest;
use App\Core\Request\Usuario\UsuarioUpdateRequest;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UsuarioService extends BaseService
{
    public function __construct(
        private readonly UsuarioRepository $usuarioRepository,
        private readonly GrupoRepository $grupoRepository,
        private readonly UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function findBy(): array
    {
        $usuarios = $this->usuarioRepository->findAll();

        $data = [];
        foreach ($usuarios as $usuario) {
            $data[] = [
                'id' => $usuario->getId(),
                'nome' => $usuario->getNome(),
                'email' => $usuario->getEmail(),
            ];
        }
        return $this->setData($data)
            ->response();
    }

    public function findById(string $id): array
    {
        $usuario = $this->usuarioRepository->find($id);
        if (!$usuario) {
            throw new NotFoundHttpException('Usuário não encontrado.');
        }

        $data = [
            'id' => $usuario->getId(),
            'nome' => $usuario->getNome(),
            'email' => $usuario->getEmail(),
        ];
        return $this->setData($data)
            ->response();
    }

    public function create(UsuarioCreateRequest $usuarioRequest): array
    {
        $usuario = new Usuario();
        $usuario->setNome($usuarioRequest->getNome());
        $usuario->setEmail($usuarioRequest->getEmail());

        $grupoId = $usuarioRequest->getGrupoId();
        if ($grupoId !== null) {
            $grupo = $this->grupoRepository->find($grupoId);
            if (!$grupo) {
                throw new NotFoundHttpException('Grupo não encontrado.');
            }
        }
        $usuario->setGrupo($grupo);

        $plaintextPassword = "brasil";
        $hashedPassword = $this->passwordHasher->hashPassword(
            $usuario,
            $plaintextPassword
        );
        $usuario->setPassword($hashedPassword);

        $this->usuarioRepository->save($usuario);

        $data = [
            'matriz' => [
                'id' => $usuario->getId(),
                'nome' => $usuario->getNome(),
                'email' => $usuario->getEmail()
            ]
        ];
        return $this->setData($data)
            ->setMessage('Usuário criado com sucesso')
            ->response();
    }

    public function update(UsuarioUpdateRequest $usuarioRequest): array
    {
        if ($usuarioRequest->getId() !== null) {
            $usuario = $this->usuarioRepository->find($usuarioRequest->getId());
            if (!$usuario) {
                throw new NotFoundHttpException('Usuário não encontrado.');
            }
        }
        $usuario->setNome($usuarioRequest->getNome());

        $grupoId = $usuarioRequest->getGrupoId();
        if ($grupoId !== null) {
            $grupo = $this->grupoRepository->find($grupoId);
            if (!$grupo) {
                throw new NotFoundHttpException('Grupo não encontrado.');
            }
        }
        $usuario->setGrupo($grupo);

        $this->usuarioRepository->update($usuario);

        $data = [
            'id' => $usuario->getId(),
            'nome' => $usuario->getNome()
        ];

        return $this->setData($data)
            ->setMessage('Usuário atualizado com sucesso.')
            ->response();
    }
}
