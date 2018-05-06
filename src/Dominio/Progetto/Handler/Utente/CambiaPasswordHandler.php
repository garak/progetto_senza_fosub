<?php

namespace Dominio\Progetto\Handler\Utente;

use Dominio\Progetto\Command\Utente\CambiaPasswordCommand;
use Dominio\Progetto\Encoder\PasswordEncoderInterface;
use Dominio\Progetto\Repository\UtenteRepositoryInterface;

class CambiaPasswordHandler extends AbstractUtenteHandler
{
    /**
     * @var PasswordEncoderInterface
     */
    protected $encoder;

    public function __construct(UtenteRepositoryInterface $repository, PasswordEncoderInterface $encoder)
    {
        parent::__construct($repository);
        $this->encoder = $encoder;
    }

    public function handle(CambiaPasswordCommand $command): void
    {
        $command->utente->setPassword($this->encoder->encode($command->nuovaPassword));
        $this->repository->add($command->utente);
    }
}
