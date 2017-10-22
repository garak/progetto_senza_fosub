<?php

namespace Dominio\Progetto\Repository;

use Dominio\Progetto\Model\Entity\Utente;
use Ramsey\Uuid\Uuid;

interface UtenteRepositoryInterface
{
    public function add(Utente $utente, bool $flush = true);

    public function get(Uuid $id): Utente;

    /**
     * @param string $email
     *
     * @return Utente|null
     */
    public function findByEmail(string $email);

    public function getByToken(string $token): Utente;
}
