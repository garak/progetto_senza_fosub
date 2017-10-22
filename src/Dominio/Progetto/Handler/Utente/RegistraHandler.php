<?php

namespace Dominio\Progetto\Handler\Utente;

use Dominio\Progetto\Command\Utente\RegistraCommand;
use Dominio\Progetto\Mailer\MailerInterface;
use Dominio\Progetto\Model\Entity\Utente;
use Dominio\Progetto\Repository\UtenteRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

final class RegistraHandler extends AbstractUtenteHandler
{
    /**
     * @var EncoderFactoryInterface
     */
    private $encoderFactory;

    /**
     * @var MailerInterface
     */
    private $mailer;

    public function __construct(
        UtenteRepositoryInterface $repository,
        EncoderFactoryInterface $encoderFactory,
        MailerInterface $mailer
    ) {
        parent::__construct($repository);
        $this->encoderFactory = $encoderFactory;
        $this->mailer = $mailer;
    }

    public function handle(RegistraCommand $command): void
    {
        $encoder = $this->encoderFactory->getEncoder(Utente::class);
        $utente = new Utente(
            Uuid::uuid4(),
            $command->email,
            $command->nome,
            $command->cognome,
            $encoder->encodePassword($command->password, null)
        );
        $this->repository->add($utente);
        $this->mailer->inviaEmailRegistrazione($utente);
    }

    // trick necessario fino al merge di https://github.com/SimpleBus/SymfonyBridge/pull/53
    public function __invoke(RegistraCommand $command)
    {
        $this->handle($command);
    }
}
