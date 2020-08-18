<?php

namespace Tests\Controller;

use Beelab\TestBundle\Test\WebTestCase as BeelabTestCase;

abstract class WebTestCase extends BeelabTestCase
{
    protected static function login(string $username = '', string $firewall = 'main', string $repository = ''): void
    {
        parent::login('utente1@example.com', $firewall, 'test.userprovider');
    }
}
