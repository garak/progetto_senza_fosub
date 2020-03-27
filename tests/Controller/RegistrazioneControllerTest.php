<?php

namespace Tests\Controller;

/**
 * @group functional
 */
class RegistrazioneControllerTest extends WebTestCase
{
    public function testErroriFormVuota(): void
    {
        $crawler = self::$client->request('GET', '/registrazione');
        $form = $crawler->selectButton('OK')->form();
        $crawler = self::$client->submit($form, [
            'registrazione[email]' => '',
            'registrazione[password]' => '',
            'registrazione[nome]' => '',
            'registrazione[cognome]' => '',
        ]);
        $this->assertCount(4, $crawler->filter('form ul li'));
    }

    public function testErroreEmailNonValidaEPasswordCorta(): void
    {
        $crawler = self::$client->request('GET', '/registrazione');
        $form = $crawler->selectButton('OK')->form();
        $crawler = self::$client->submit($form, [
            'registrazione[email]' => 'invalid',
            'registrazione[password]' => 'short',
            'registrazione[nome]' => 'x',
            'registrazione[cognome]' => 'y',
        ]);
        $this->assertCount(2, $crawler->filter('form ul li'));
    }

    public function testErroriEmailGiaRegistrata(): void
    {
        $crawler = self::$client->request('GET', '/registrazione');
        $form = $crawler->selectButton('OK')->form();
        $crawler = self::$client->submit($form, [
            'registrazione[email]' => 'utente1@example.com',
            'registrazione[password]' => 'segreta1',
            'registrazione[nome]' => 'x',
            'registrazione[cognome]' => 'y',
        ]);
        $this->assertCount(1, $crawler->filter('form ul li'));
    }

    public function testOk(): void
    {
        $crawler = self::$client->request('GET', '/registrazione');
        $form = $crawler->selectButton('OK')->form();
        self::$client->enableProfiler();
        self::$client->submit($form, [
            'registrazione[email]' => 'ciccio@example.org',
            'registrazione[password]' => 'segreta1',
            'registrazione[nome]' => 'Ciccio',
            'registrazione[cognome]' => 'Panino',
        ]);
        $this->assertMailSent(1);
        $crawler = self::$client->followRedirect();
        $this->assertCount(1, $crawler->filter('div.alert-success'));
    }

    public function testConfermaConTokekSbaglato(): void
    {
        self::$client->request('GET', '/registrazione/conferma/wrongtoken');
        $this->assertTrue(self::$client->getResponse()->isClientError());
    }

    public function testConferma(): void
    {
        self::$client->request('GET', '/registrazione/conferma/afaketoken');
        $crawler = self::$client->followRedirect();
        $this->assertTrue(self::$client->getResponse()->isOk());
        $this->assertCount(1, $crawler->filter('p:contains("Utente: daConfermare@example.com")'));
    }

    public function testUtenteGiaLoggatoNonVedeRegistrazione(): void
    {
        $this->login();
        self::$client->request('GET', '/registrazione');
        $this->assertTrue(self::$client->getResponse()->isRedirect());
    }

    public function testUtenteGiaLoggatoNonVedeOk(): void
    {
        $this->login();
        self::$client->request('GET', '/registrazione/ok');
        $this->assertTrue(self::$client->getResponse()->isRedirect());
    }

    public function testUtenteGiaLoggatoNonPuoConfermare(): void
    {
        $this->login();
        self::$client->request('GET', '/registrazione/conferma/afaketoken');
        $this->assertTrue(self::$client->getResponse()->isRedirect());
    }
}
