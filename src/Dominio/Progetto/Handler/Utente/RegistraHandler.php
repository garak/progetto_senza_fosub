<?php

namespace Dominio\Progetto\Handler\Utente;

use Dominio\Progetto\Command\Utente\RegistraCommand;
use Dominio\Progetto\Encoder\PasswordEncoderInterface;
use Dominio\Progetto\Mailer\MailerInterface;
use Dominio\Progetto\Model\Entity\Utente;
use Dominio\Progetto\Repository\UtenteRepositoryInterface;
use Ramsey\Uuid\Uuid;

final class RegistraHandler extends AbstractUtenteHandler
{
    private PasswordEncoderInterface $encoder;

    private MailerInterface $mailer;

    public function __construct(
        UtenteRepositoryInterface $repository,
        PasswordEncoderInterface $encoder,
        MailerInterface $mailer
    ) {
        parent::__construct($repository);
        $this->encoder = $encoder;
        $this->mailer = $mailer;
    }

    public function handle(RegistraCommand $command): void
    {
        $utente = new Utente(
            Uuid::uuid4(),
            $command->email,
            $command->nome,
            $command->cognome,
            $this->encoder->encode($command->password)
        );
        $this->repository->add($utente);
        $this->mailer->inviaEmailRegistrazione($utente);
    }
}
