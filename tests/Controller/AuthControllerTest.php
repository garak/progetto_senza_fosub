<?php

namespace Tests\Controller;

/**
 * @group functional
 */
class AuthControllerTest extends WebTestCase
{
    public function testLoginErrore(): void
    {
        $crawler = self::$client->request('GET', '/login');
        $form = $crawler->filter('button[type="submit"]')->form();
        self::$client->submit($form, [
            '_username' => 'nonexistant@foo.bar',
            '_password' => 'blablablah',
        ]);
        self::$client->followRedirect();
        self::assertResponseIsSuccessful();
        self::assertSelectorExists('div.alert-danger');
    }

    public function testUtenteNonAttivo(): void
    {
        $crawler = self::$client->request('GET', '/login');
        $form = $crawler->filter('button[type="submit"]')->form();
        self::$client->submit($form, [
            '_username' => 'daConfermare@example.com',
            '_password' => 'bellaperte',
        ]);
        self::$client->followRedirect();
        self::assertResponseIsSuccessful();
        self::assertSelectorExists('div.alert-danger:contains("non attivo")');
    }

    public function testErroreGenericoInSessione(): void
    {
        self::setSessionException();
        self::$client->request('GET', '/login');
        self::assertResponseIsSuccessful();
        self::assertSelectorExists('div.alert-danger:contains("error")');
    }

    public function testLoginOk(): void
    {
        $crawler = self::$client->request('GET', '/login');
        $form = $crawler->filter('button[type="submit"]')->form();
        self::$client->submit($form, [
            '_username' => 'utente1@example.com',
            '_password' => 'ciaone',
        ]);
        self::$client->followRedirect();
        self::assertResponseIsSuccessful();
        self::assertSelectorNotExists('div.alert-danger');
    }

    public function testUtenteAutenticatoNonPuoVedereLogin(): void
    {
        self::login();
        self::$client->request('GET', '/login');
        self::assertResponseRedirects();
    }
}
