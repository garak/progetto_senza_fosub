<?php

namespace Dominio\Progetto\Handler\Utente;

use Dominio\Progetto\Repository\UtenteRepositoryInterface;

abstract class AbstractUtenteHandler
{
    /**
     * @var UtenteRepositoryInterface
     */
    protected $repository;

    public function __construct(UtenteRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}
