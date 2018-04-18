<?php

namespace App\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Dominio\Progetto\Model\Entity\Utente;
use Dominio\Progetto\Repository\UtenteRepositoryInterface;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Security\Core\Exception\DisabledException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UtenteRepository implements UtenteRepositoryInterface, UserProviderInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function add(Utente $utente, bool $flush = true): void
    {
        $this->manager->persist($utente);
        if ($flush) {
            $this->manager->flush();
        }
    }

    public function get(UuidInterface $id): Utente
    {
        return $this
            ->getBuilder()
            ->where('u.id = :id')
            ->setParameter('id', $id)
            ->setMaxResults(1)
            ->getQuery()
            ->getSingleResult()
        ;
    }

    public function getByToken(string $token): Utente
    {
        return $this
            ->getBuilder()
            ->where('u.tokenConferma = :token')
            ->setParameter('token', $token)
            ->setMaxResults(1)
            ->getQuery()
            ->getSingleResult()
        ;
    }

    public function findByEmail(string $email): ?Utente
    {
        return $this
            ->getBuilder()
            ->where('u.email = :email')
            ->setParameter('email', $email)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function loadUserByUsername($username): Utente
    {
        if (null === $utente = $this->findByEmail($username)) {
            throw new UsernameNotFoundException(sprintf('Utente "%s" non trovato', $username));
        }
        if (!$utente->isAttivo()) {
            throw new DisabledException('Utente non attivo.');
        }

        return $utente;
    }

    public function refreshUser(UserInterface $utente): Utente
    {
        $class = get_class($utente);
        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(sprintf('Istanza di "%s" non supportata.', $class));
        }

        return $this->get($utente->getId());
    }

    public function supportsClass($class): bool
    {
        return Utente::class === $class;
    }

    private function getBuilder(): QueryBuilder
    {
        return $this->manager->createQueryBuilder()->from(Utente::class, 'u')->select('u');
    }
}
