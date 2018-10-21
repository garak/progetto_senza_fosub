<?php

namespace App\EventListener;

use Doctrine\ORM\NoResultException;
use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Intercetta eccezioni relative al dominio e lancia invece eccezioni http.
 */
class ExceptionListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }

    public function onKernelException(GetResponseForExceptionEvent $event): void
    {
        $exception = $event->getException();
        if ($exception instanceof NoResultException) {
            $event->setException(new NotFoundHttpException('Not Found', $exception));
        } elseif ($exception instanceof InvalidUuidStringException) {
            $event->setException(new NotFoundHttpException('Not Found (invalid Uuid)', $exception));
        }
    }
}
