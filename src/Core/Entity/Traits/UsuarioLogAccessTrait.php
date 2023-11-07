<?php

namespace App\Core\Entity\Traits;

use App\Core\Entity\Usuario;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

trait UsuarioLogAccessTrait
{
    #[ORM\OneToMany(targetEntity: Usuario::class, mappedBy: 'usuario')]
    private Collection $logAccess;

    public function __construct()
    {
        $this->logAccess = new ArrayCollection();
    }

    public function getLogAccess(): Collection
    {
        return $this->logAccess;
    }
}
