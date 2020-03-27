<?php

namespace App\EventListener;

use Doctrine\ORM\NoResultException;
use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Intercetta eccezioni relative al dominio e lancia invece eccezioni http.
 */
final class ExceptionListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        if ($exception instanceof NoResultException) {
            $event->setThrowable(new NotFoundHttpException('Not Found', $exception));
        } elseif ($exception instanceof InvalidUuidStringException) {
            $event->setThrowable(new NotFoundHttpException('Not Found (invalid Uuid)', $exception));
        }
    }
}
