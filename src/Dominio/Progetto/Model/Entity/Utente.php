<?php

namespace Dominio\Progetto\Model\Entity;

use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class Utente implements UserInterface
{
    /**
     * @var UuidInterface
     */
    private $id;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $password;

    /**
     * @var bool
     */
    protected $attivo = false;

    /**
     * @var string
     */
    private $nome;

    /**
     * @var string
     */
    private $cognome;

    /**
     * @var \DateTimeInterface
     */
    private $creato;

    /**
     * @var \DateTimeInterface
     */
    private $ultimoLogin;

    /**
     * @var string
     */
    private $tokenConferma;

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
        $this->tokenConferma = bin2hex(random_bytes(21));
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

    public function getUsername(): string
    {
        return $this->email;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getCognome(): string
    {
        return $this->cognome;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function isAttivo(): bool
    {
        return $this->attivo;
    }

    public function attiva(): void
    {
        $this->attivo = true;
    }

    public function getTokenConferma(): ?string
    {
        return $this->tokenConferma;
    }

    public function getUltimoLogin(): ?\DateTimeInterface
    {
        return $this->ultimoLogin;
    }

    public function getCreato(): \DateTimeInterface
    {
        return $this->creato;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function resetPassword(string $token = null): void
    {
        $this->tokenConferma = $token ?? bin2hex(random_bytes(21));
    }

    public function setUltimoLogin(\DateTimeInterface $tempo): void
    {
        $this->ultimoLogin = $tempo;
    }

    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function eraseCredentials(): void
    {
    }

    public function getSalt(): void
    {
    }
}
