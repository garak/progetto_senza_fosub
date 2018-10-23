<?php

namespace App\Security\User;

use Dominio\Progetto\Repository\UtenteRepositoryInterface;
use Symfony\Component\Security\Core\Exception\DisabledException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

final class UserProvider implements UserProviderInterface
{
    /** @var UtenteRepositoryInterface */
    private $utenteRepository;

    public function __construct(UtenteRepositoryInterface $utenteRepository)
    {
        $this->utenteRepository = $utenteRepository;
    }

    public function loadUserByUsername($username): ?User
    {
        if (null === ($utente = $this->utenteRepository->findByEmail($username))) {
            throw new UsernameNotFoundException(\sprintf('Utente "%s" non trovato', $username));
        }
        if (!$utente->isAttivo()) {
            throw new DisabledException('Utente non attivo.');
        }

        return new User($utente);
    }

    public function supportsClass($class): bool
    {
        return User::class === $class;
    }

    public function refreshUser(UserInterface $user): User
    {
        $class = \get_class($user);
        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(\sprintf('Istanza di "%s" non supportata.', $class));
        }

        return new User($this->utenteRepository->get($user->getUtente()->getId()));
    }
}
