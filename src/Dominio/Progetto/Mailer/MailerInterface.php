<?php

namespace Dominio\Progetto\Mailer;

use Dominio\Progetto\Model\Entity\Utente;

interface MailerInterface
{
    public function inviaEmailRegistrazione(Utente $utente): void;

    public function inviaEmailResetPassword(Utente $utente): void;
}
