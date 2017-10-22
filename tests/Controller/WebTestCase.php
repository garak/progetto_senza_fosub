<?php

namespace Tests\Controller;

use App\Repository\UtenteRepository;
use Beelab\TestBundle\Test\WebTestCase as BeelabTestCase;

abstract class WebTestCase extends BeelabTestCase
{
    protected function login(string $username = '', string $firewall = 'main', string $repository = '')
    {
        parent::login('utente1@example.com', $firewall, UtenteRepository::class);
    }
}
