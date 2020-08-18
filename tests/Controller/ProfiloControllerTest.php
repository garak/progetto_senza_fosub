<?php

namespace Tests\Controller;

/**
 * @group functional
 */
class ProfiloControllerTest extends WebTestCase
{
    public function testCambioPasswordErrore(): void
    {
        self::login('user1@example.com', 'main', 'test.userprovider_big_picture');
        $crawler = self::$client->request('GET', '/cambia-password');
        self::assertResponseIsSuccessful();
        $form = $crawler->selectButton('aggiorna')->form([
            'cambio_password[vecchiaPassword]' => 'sbagliata',
            'cambio_password[nuovaPassword]' => 'corta',
        ]);
        $crawler = self::$client->submit($form);
        self::assertSelectorCounts(2, 'form div.has-error');
    }

    public function testCambioPasswordOk(): void
    {
        self::login('user1@example.com', 'main', 'test.userprovider_big_picture');
        $crawler = self::$client->request('GET', '/cambia-password');
        $form = $crawler->selectButton('aggiorna')->form([
            'cambio_password[vecchiaPassword]' => 'ciaone',
            'cambio_password[nuovaPassword]' => 'prontone',
        ]);
        self::$client->submit($form);
        self::$client->followRedirect();
        self::assertResponseIsSuccessful();
    }
}
