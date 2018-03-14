<?php

namespace Dominio\Progetto\Handler\Utente;

use Dominio\Progetto\Command\Utente\ConfermaRegistrazioneCommand;

final class ConfermaRegistrazioneHandler extends AbstractUtenteHandler
{
    public function handle(ConfermaRegistrazioneCommand $command): void
    {
        $utente = $this->repository->getByToken($command->token);
        $utente->attiva();
        $this->repository->add($utente);
        $command->utente = $utente;
    }
}
