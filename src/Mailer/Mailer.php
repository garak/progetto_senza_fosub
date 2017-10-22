<?php

namespace App\Mailer;

use Dominio\Progetto\Mailer\MailerInterface;
use Dominio\Progetto\Model\Entity\Utente;
use Swift_Mailer as Swift;
use Symfony\Component\Templating\EngineInterface as Twig;

final class Mailer implements MailerInterface
{
    /**
     * @var Swift
     */
    private $swift;

    /**
     * @var Twig
     */
    private $twig;

    public function __construct(Swift $swift, Twig $twig)
    {
        $this->swift = $swift;
        $this->twig = $twig;
    }

    public function inviaEmailRegistrazione(Utente $utente): void
    {
        $body = $this->twig->render('email/registrazione.twig', ['utente' => $utente]);
        $message = $this->swift
            ->createMessage()
            ->setFrom('noreply@progetto.local')   // TODO spostare in conf e iniettare
            ->setTo($utente->getEmail())
            ->setBody($body)
            ->setSubject('Conferma registrazione')
        ;
        $this->swift->send($message);
    }

    public function inviaEmailResetPassword(Utente $utente): void
    {
        $body = $this->twig->render('email/reset_password.twig', ['utente' => $utente]);
        $message = $this->swift
            ->createMessage()
            ->setFrom('noreply@progetto.local')   // TODO vedi sopra
            ->setTo($utente->getEmail())
            ->setBody($body)
            ->setSubject('Reset della password')
        ;
        $this->swift->send($message);
    }
}
