<?php

namespace Dominio\Progetto\Handler\Utente;

use Dominio\Progetto\Command\Utente\CambiaPasswordCommand;
use Dominio\Progetto\Encoder\PasswordEncoderInterface;
use Dominio\Progetto\Repository\UtenteRepositoryInterface;

final class CambiaPasswordHandler extends AbstractUtenteHandler
{
    protected PasswordEncoderInterface $encoder;

    public function __construct(UtenteRepositoryInterface $repository, PasswordEncoderInterface $encoder)
    {
        parent::__construct($repository);
        $this->encoder = $encoder;
    }

    public function handle(CambiaPasswordCommand $command): void
    {
        $command->utente->password = $this->encoder->encode($command->nuovaPassword);
        $this->repository->add($command->utente);
    }
}
