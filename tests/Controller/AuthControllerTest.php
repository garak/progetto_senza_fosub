<?php

namespace Tests\Controller;

use Symfony\Component\BrowserKit\Cookie;
use Tests\SerializableException;

/**
 * @group functional
 */
class AuthControllerTest extends WebTestCase
{
    public function testLoginErrore(): void
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->filter('button[type="submit"]')->form();
        $this->client->submit($form, [
            '_username' => 'nonexistant@foo.bar',
            '_password' => 'blablablah',
        ]);
        $crawler = $this->client->followRedirect();
        $this->assertTrue($this->client->getResponse()->isOk());
        $this->assertCount(1, $crawler->filter('div.alert-danger'));
    }

    public function testUtenteNonAttivo(): void
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->filter('button[type="submit"]')->form();
        $this->client->submit($form, [
            '_username' => 'daConfermare@example.com',
            '_password' => 'bellaperte',
        ]);
        $crawler = $this->client->followRedirect();
        $this->assertTrue($this->client->getResponse()->isOk());
        $this->assertCount(1, $crawler->filter('div.alert-danger:contains("non attivo")'));
    }

    public function testErroreGenericoInSessione(): void
    {
        $session = $this->container->get('session');
        $session->set('_security.last_error', new SerializableException('errore...'));
        $session->save();
        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
        $crawler = $this->client->request('GET', '/login');
        $this->assertTrue($this->client->getResponse()->isOk());
        $this->assertCount(1, $crawler->filter('div.alert-danger:contains("Errore inatteso")'));
    }

    public function testLoginOk(): void
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->filter('button[type="submit"]')->form();
        $this->client->submit($form, [
            '_username' => 'utente1@example.com',
            '_password' => 'ciaone',
        ]);
        $crawler = $this->client->followRedirect();
        $this->assertTrue($this->client->getResponse()->isOk());
        $this->assertCount(0, $crawler->filter('div.alert-danger'));
    }

    public function testUtenteAutenticatoNonPuoVedereLogin(): void
    {
        $this->login();
        $this->client->request('GET', '/login');
        $this->assertTrue($this->client->getResponse()->isRedirect());
    }
}
