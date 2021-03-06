<?php

namespace Dominio\Progetto\Command\Utente;

class ConfermaRegistrazioneCommand
{
    /**
     * @var string
     */
    public $token;

    /**
     * @var \Dominio\Progetto\Model\Entity\Utente
     */
    public $utente;

    public function __construct(string $token)
    {
        $this->token = $token;
    }
}
