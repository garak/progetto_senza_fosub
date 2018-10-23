<?php

namespace App\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Dominio\Progetto\Model\Entity\Utente;
use Dominio\Progetto\Repository\UtenteRepositoryInterface;
use Ramsey\Uuid\UuidInterface;

class UtenteRepository implements UtenteRepositoryInterface
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

    private function getBuilder(): QueryBuilder
    {
        return $this->manager->createQueryBuilder()->from(Utente::class, 'u')->select('u');
    }
}
