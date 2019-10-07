<?php

namespace App\Security\User;

use Dominio\Progetto\Model\Entity\Utente;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;

final class User implements UserInterface, EquatableInterface
{
    /** @var Utente */
    private $utente;

    public function __construct(Utente $utente)
    {
        $this->utente = $utente;
    }

    public function __toString(): string
    {
        return $this->getUsername();
    }

    public function getUtente(): Utente
    {
        return $this->utente;
    }

    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function getPassword(): string
    {
        return $this->utente->getPassword();
    }

    public function getUsername(): string
    {
        return $this->utente->getEmail();
    }

    public function eraseCredentials(): void
    {
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function isEqualTo(UserInterface $user): bool
    {
        return $user->getUsername() === $this->getUsername();
    }
}
