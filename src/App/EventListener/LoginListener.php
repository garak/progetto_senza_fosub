<?php

namespace App\EventListener;

use Dominio\Progetto\Model\Entity\Utente;
use Dominio\Progetto\Repository\UtenteRepositoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;

/**
 * Imposta il tempo di "ultimoLogin" per l'utente.
 */
final class LoginListener implements EventSubscriberInterface
{
    private UtenteRepositoryInterface $repository;

    public function __construct(UtenteRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            SecurityEvents::INTERACTIVE_LOGIN => 'onSecurityInteractiveLogin',
        ];
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event): void
    {
        $utente = $event->getAuthenticationToken()->getUser()->getUtente();
        if ($utente instanceof Utente) {
            $utente->ultimoLogin = new \DateTimeImmutable();
            $this->repository->add($utente);
        }
    }
}
