<?php

namespace Tests\Controller;

class RegistrazioneControllerTest extends WebTestCase
{
    public function testErroriFormVuota()
    {
        $crawler = $this->client->request('GET', '/registrazione');
        $form = $crawler->selectButton('OK')->form();
        $crawler = $this->client->submit($form, [
            'registrazione[email]' => '',
            'registrazione[password]' => '',
            'registrazione[nome]' => '',
            'registrazione[cognome]' => '',
        ]);
        $this->assertCount(4, $crawler->filter('form ul li'));
    }

    public function testErroreEmailNonValidaEPasswordCorta()
    {
        $crawler = $this->client->request('GET', '/registrazione');
        $form = $crawler->selectButton('OK')->form();
        $crawler = $this->client->submit($form, [
            'registrazione[email]' => 'invalid',
            'registrazione[password]' => 'short',
            'registrazione[nome]' => 'x',
            'registrazione[cognome]' => 'y',
        ]);
        $this->assertCount(2, $crawler->filter('form ul li'));
    }

    public function testErroriEmailGiaRegistrata()
    {
        $crawler = $this->client->request('GET', '/registrazione');
        $form = $crawler->selectButton('OK')->form();
        $crawler = $this->client->submit($form, [
            'registrazione[email]' => 'utente1@example.com',
            'registrazione[password]' => 'segreta1',
            'registrazione[nome]' => 'x',
            'registrazione[cognome]' => 'y',
        ]);
        $this->assertCount(1, $crawler->filter('form ul li'));
    }

    public function testOk()
    {
        $crawler = $this->client->request('GET', '/registrazione');
        $form = $crawler->selectButton('OK')->form();
        $this->client->enableProfiler();
        $crawler = $this->client->submit($form, [
            'registrazione[email]' => 'ciccio@example.org',
            'registrazione[password]' => 'segreta1',
            'registrazione[nome]' => 'Ciccio',
            'registrazione[cognome]' => 'Panino',
        ]);
        $this->assertMailSent(1);
        $crawler = $this->client->followRedirect();
        $this->assertCount(1, $crawler->filter('div.alert-success'));
    }

    public function testConfermaConTokekSbaglato()
    {
        $this->client->request('GET', '/registrazione/conferma/wrongtoken');
        $this->assertTrue($this->client->getResponse()->isClientError());
    }

    public function testConferma()
    {
        $this->client->request('GET', '/registrazione/conferma/afaketoken');
        $crawler = $this->client->followRedirect();
        $this->assertTrue($this->client->getResponse()->isOk());
        // TODO il menu utente non c'è ancora
        //$this->assertCount(1, $crawler->filter('.navbar-right i.fa-user-circle'));
    }

    public function testUtenteGiaLoggatoNonVedeRegistrazione()
    {
        $this->login();
        $this->client->request('GET', '/registrazione');
        $this->assertTrue($this->client->getResponse()->isRedirect());
    }

    public function testUtenteGiaLoggatoNonVedeOk()
    {
        $this->login();
        $this->client->request('GET', '/registrazione/ok');
        $this->assertTrue($this->client->getResponse()->isRedirect());
    }

    public function testUtenteGiaLoggatoNonPuoConfermare()
    {
        $this->login();
        $this->client->request('GET', '/registrazione/conferma/afaketoken');
        $this->assertTrue($this->client->getResponse()->isRedirect());
    }
}
