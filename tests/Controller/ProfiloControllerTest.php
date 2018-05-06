<?php

namespace Tests\Controller;

/**
 * @group functional
 */
class ProfiloControllerTest extends WebTestCase
{
    public function testCambioPasswordErrore(): void
    {
        $this->login('user1@example.com', 'main', 'test.userprovider_big_picture');
        $crawler = $this->client->request('GET', '/cambia-password');
        $this->assertTrue($this->client->getResponse()->isOk());
        $form = $crawler->selectButton('aggiorna')->form([
            'cambio_password[vecchiaPassword]' => 'sbagliata',
            'cambio_password[nuovaPassword]' => 'corta',
        ]);
        $crawler = $this->client->submit($form);
        $this->assertCount(2, $crawler->filter('form div.has-error'));
    }

    public function testCambioPasswordOk(): void
    {
        $this->login('user1@example.com', 'main', 'test.userprovider_big_picture');
        $crawler = $this->client->request('GET', '/cambia-password');
        $form = $crawler->selectButton('aggiorna')->form([
            'cambio_password[vecchiaPassword]' => 'ciaone',
            'cambio_password[nuovaPassword]' => 'prontone',
        ]);
        $this->client->submit($form);
        $this->client->followRedirect();
        $this->assertTrue($this->client->getResponse()->isOk());

    }
}
