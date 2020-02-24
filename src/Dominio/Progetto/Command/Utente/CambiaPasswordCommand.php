<?php

namespace Dominio\Progetto\Command\Utente;

use Dominio\Progetto\Model\Entity\Utente;

class CambiaPasswordCommand
{
    /**
     * @var string
     */
    public $vecchiaPassword;

    /**
     * @var string
     */
    public $nuovaPassword;

    /**
     * @var Utente
     */
    public $utente;

    public function __construct(Utente $utente)
    {
        $this->utente = $utente;
    }
}
