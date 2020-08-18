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
        self::assertSelectorCounts(4, 'form ul li');
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
        self::assertSelectorCounts(2, 'form ul li');
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
        self::assertSelectorCounts(1, 'form ul li');
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
        self::assertMailSent(1);
        self::$client->followRedirect();
        self::assertSelectorExists('div.alert-success');
    }

    public function testConfermaConTokekSbaglato(): void
    {
        self::$client->request('GET', '/registrazione/conferma/wrongtoken');
        self::assertResponseStatusCodeSame(404);
    }

    public function testConferma(): void
    {
        self::$client->request('GET', '/registrazione/conferma/afaketoken');
        self::$client->followRedirect();
        self::assertResponseIsSuccessful();
        self::assertSelectorExists('p:contains("Utente: daConfermare@example.com")');
    }

    public function testUtenteGiaLoggatoNonVedeRegistrazione(): void
    {
        self::login();
        self::$client->request('GET', '/registrazione');
        self::assertResponseRedirects();
    }

    public function testUtenteGiaLoggatoNonVedeOk(): void
    {
        self::login();
        self::$client->request('GET', '/registrazione/ok');
        self::assertResponseRedirects();
    }

    public function testUtenteGiaLoggatoNonPuoConfermare(): void
    {
        self::login();
        self::$client->request('GET', '/registrazione/conferma/afaketoken');
        self::assertResponseRedirects();
    }
}
