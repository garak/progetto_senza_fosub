<?php

namespace Dominio\Progetto\Handler\Utente;

use Dominio\Progetto\Repository\UtenteRepositoryInterface;

abstract class AbstractUtenteHandler
{
    protected UtenteRepositoryInterface $repository;

    public function __construct(UtenteRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}
