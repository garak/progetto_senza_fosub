<?php

namespace Dominio\Progetto\Repository;

use Dominio\Progetto\Model\Entity\Utente;
use Ramsey\Uuid\UuidInterface;

interface UtenteRepositoryInterface
{
    public function add(Utente $utente, bool $flush = true);

    public function get(UuidInterface $id): Utente;

    public function findByEmail(string $email): ?Utente;

    public function getByToken(string $token): Utente;
}
