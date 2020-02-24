<?php

namespace Dominio\Progetto\Model\Entity;

use Ramsey\Uuid\UuidInterface;

class Utente
{
    public UuidInterface $id;

    public string $email;

    public string $password;

    public bool $attivo = false;

    public string $nome;

    public string $cognome;

    public \DateTimeInterface $creato;

    public ?\DateTimeInterface $ultimoLogin;

    public ?string $tokenConferma;

    public function __construct(
        UuidInterface $id,
        string $email,
        string $nome,
        string $cognome,
        string $password
    ) {
        $this->id = $id;
        $this->email = $email;
        $this->nome = $nome;
        $this->cognome = $cognome;
        $this->creato = new \DateTimeImmutable();
        $this->tokenConferma = \bin2hex(\random_bytes(21));
        $this->password = $password;
    }

    public function __toString(): string
    {
        return $this->email;
    }

    public function aggiorna(string $email, string $nome, string $cognome): void
    {
        $this->email = $email;
        $this->nome = $nome;
        $this->cognome = $cognome;
    }

    public function attiva(): void
    {
        $this->attivo = true;
    }

    public function resetPassword(?string $token = null): void
    {
        $this->tokenConferma = $token ?? \bin2hex(\random_bytes(21));
    }
}
